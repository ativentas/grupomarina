<?php

namespace Pedidos\Http\Controllers;

use DB;
use Auth;
use Pedidos\Models\User;
use Pedidos\Models\Articulo;
use Pedidos\Models\Plantilla;
use Pedidos\Models\LineaPlantilla;
use Pedidos\Models\Inventario;
use Pedidos\Models\LineaInventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
	
	public function getPendientes()
	{
		$inventarios = Inventario::where('user_id', Auth::user()->id)->where('estado', 'Pendiente')->orderBy('created_at', 'ASC')->get();
		// dd($inventarios);
		return view('inventarios.pendientes')->with('inventarios', $inventarios);
	}

	public function getInventariosCompletos()
	{
		$inventarios = Inventario::where('user_id', Auth::user()->id)->where('estado', 'Cerrado')
			->orderBy('updated_at', 'DESC')->get();
		// dd($inventarios);
		return view('inventarios.completos')->with('inventarios', $inventarios);
	}
	public function getInventario($inventario_id)
	{
		$lineas =LineaInventario::where('inventario_id',$inventario_id)->get();
		if(!Auth::user()->isAdmin() && !$lineas->count()){
			return redirect()->back();
		}
		$inventario = Inventario::where('id',$inventario_id)->first();
		$restaurante = $inventario->restaurante;
		$seccion = $inventario->seccion;
		$categories = Articulo::all();
		if(Auth::user()->isAdmin())
		{
		return view('inventarios.detalle')
			->with('inventario_id', $inventario_id)
			->with('restaurante', $restaurante)
			->with('lineas', $lineas)
			->with('seccion', $seccion)
			->with('inventario', $inventario)
			->with('categories', $categories)
			;
	
		}
		return view('inventarios.detalleeditable')
			->with('inventario_id', $inventario_id)
			->with('restaurante', $restaurante)
			->with('lineas', $lineas)
			->with('seccion', $seccion)
			->with('inventario', $inventario)
			->with('categories', $categories)
			;
	}

	public function postCompletoInventario(Request $request, $inventario_id)
	{		
	

		$lineas =LineaInventario::where('inventario_id',$inventario_id)->get();
		
		foreach ($lineas as $linea) {
			$lineaId=$linea->id;
			$cantidadName = "cantidad"."_".$lineaId;
			$unidades = $request->input($cantidadName);
			$linea->unidades = $unidades;
			$linea->save();

		}

		if(isset($_POST['oficina'])){
			
			if ($request->completado === 'yes') {
			    // checked. Actualizar campo 'estado'
			 	$inventario = Inventario::where('id', $inventario_id)->first();
				$estado = 'Cerrado';
				$inventario->estado = $estado;
				$inventario->save();

				return view('home');   
			
			} else {
			    // unchecked
			    return redirect()->back()->with('info', 'Si ya has terminado el inventario, debes marcar la casilla');
			}	


		}
		if(isset($_POST['cambios'])){
			return redirect()->back()->with('info', 'Cambios Guardados!!!');
		}		
		
	}

	public function postFicheroInventario($inventario_id)
	{
		$result = DB::table('lineasInventarios')->where('inventario_id',$inventario_id)->select('id', 'articulo_codint', 'talla', 'color', 'unidades', 'precio', 'dto', 'total', 'cod_barras')->get();

  		// dd($result);
		$fichero = fopen("inventario".$inventario_id.".txt","w");
		
  		foreach ($result as $linea) {
  			$id = $linea->id;
  			$articulo = $linea->articulo_codint;
  			$talla = $linea->talla;
  			$color = $linea->color;
  			$unidades = $linea->unidades;
  			$precio = number_format($linea->precio, 2, ',', ' ');
  			$dto = number_format($linea->dto, 2, ',', ' ');
  			$total = number_format($linea->total, 2, ',', ' ');
  			$cod_barras = $linea->cod_barras.PHP_EOL;
  			fwrite($fichero,$id."|".$articulo."|".$talla."|".$color."|".$unidades."|".$precio."|".$dto."|".$total."|".$cod_barras); //write to txtfile
  		}
  		
  		fclose($fichero);

  		return response()->download(public_path("inventario".$inventario_id.".txt"));
		
		// dd($inventario_id);
	}

	public function getAdminInventarios()
	{
		
		if (Auth::user()->isAdmin()){
			$plantillas = Plantilla::all();
			$inventariosPendientes = Inventario::where('estado', 'Pendiente')->orderBy('created_at', 'DESC')->get();
			$inventariosCerrados = Inventario::where('estado', 'Cerrado')->orderBy('updated_at', 'DESC')->get();
			$empleados = User::NoAdmin()->get();
			return view('inventarios.control')
				->with('plantillas', $plantillas)
				->with('inventariosPendientes', $inventariosPendientes)
				->with('inventariosCerrados', $inventariosCerrados)
				->with('empleados', $empleados);
		}
		return view('home');
		
	}

	public function crearInventario(Request $request)
	{
		
		$this->validate($request, [
			'plantillaId' => 'required',
			'restaurante'=>'required',
			'empleadoId' =>'required'
		]);

		$plantilla = Plantilla::where('id',$_POST['plantillaId'])->first();
		$seccion ="";
		if ($plantilla) {
			$seccion = $plantilla->seccion;
		}
	
		$inventario = Inventario::create([
			'restaurante'=>$_POST['restaurante'],
			'user_id' =>$_POST['empleadoId'],
			]);

		if ($request->plantillaId == "BLANCO"){

		}
		else {

			$lineasP = LineaPlantilla::where('plantilla_id', $_POST['plantillaId'])->get()->toArray();

			foreach ($lineasP as $lineaP) {
				LineaInventario::insert([
				'inventario_id'=> $inventario->id,
				'articulo_codint' => $lineaP['articulo_codint']
				]);

			}
		}
		$lineas = LineaInventario::where('inventario_id',$inventario->id)->get();
		$categories = Articulo::all();
		
		return redirect()->route('inventarios.detalle', $inventario->id)->with('info','Añade mas artículos o Finaliza para terminar');

// 		return view('inventarios.detalle')
// 			->with('inventario_id', $inventario->id)
// 			->with('restaurante', $inventario->restaurante)
// 			->with('lineas', $lineas)
// 			->with('categories', $categories)
// 			->with('seccion', $seccion)
// 			->with('inventario', $inventario);
	}

	public function nuevaLineaInventario(Request $request, $inventario_id)
	{
		$this->validate($request, ['articuloId'=>'required']);
		
		$lineaInventario = LineaInventario::create([
			'articulo_codint'=>$request->input('articuloId'),
			'inventario_id' =>$inventario_id,
			]);
		
		return redirect()->back();
	}

	public function actualizarLineaInventario(Request $request, $lineaId)
	{
		$linea = LineaInventario::where('id', $lineaId)->first();
		$unidades = $request->input('cantidad');
		$linea->unidades = $unidades;
		$linea->save();

		return redirect()->back();
	}

	public function deleteLineaInventario($lineaId)
	{
		$linea = LineaInventario::where('id', $lineaId)->first();
		$inventario = $linea->inventario->id;

		if($linea){
			$linea->delete();
		}
		return redirect()->route('inventarios.detalle', $inventario);
		// return redirect()->back();
	}

	public function borrarInventario($inventario_id)
	{
		$inventario = Inventario::where('id', $inventario_id)->first();
		
		if (!$inventario){
			return redirect()->back()->with('info', 'No se ha podido borrar...');
		}
		//SI EL INVENTARIO ESTA CERRADO, YA NUNCA SE PUEDE BORRAR
		if($inventario->estado=='Cerrado'){
			return redirect()->back()
				->with('info', 'ESTE INVENTARIO YA ESTA ARCHIVADO Y NO SE PUEDE BORRAR');
		}

		//COMPROBAR SI EL INVENTARIO ESTÁ VACÍO.
		$contenido = LineaInventario::where('inventario_id', $inventario_id)->first();
		if ($contenido){
			return redirect()->back()
				->with('info', 'NO SE PUEDE ELIMNAR. ¡¡¡ HAY QUE ELIMINAR EL DETALLE PRIMERO !!!');
		}
		//borrar el inventario

		$inventario->delete();

		return redirect()->back()
			->with('info', 'Inventario eliminado!!!');
	}

	public function getAdminPlantillas()
	{
		
		if (Auth::user()->isAdmin()){
			$plantillas = Plantilla::all();
			return view('plantillas.control')
				->with('plantillas', $plantillas);
		}
		return view('home');
		
	}

	public function crearPlantilla(Request $request)
	{
		$this->validate($request, [
			'restaurante' => 'required',
			'seccion'=>'required',
			'descripcion' =>'required'
		]);

		$plantilla = Plantilla::create([
			'restaurante'=>$_POST['restaurante'],
			'seccion' =>$_POST['seccion'],
			'descripcion' =>$_POST['descripcion']
			]);

		$lineas = LineaPlantilla::where('plantilla_id',$plantilla->id)->get();
		$categories = Articulo::all();

		return redirect()->route('plantilla.detalle', $plantilla->id);

		// return view('plantillas.detalle')
		// 	->with('plantilla_id', $plantilla->id)
		// 	->with('restaurante', $plantilla->restaurante)
		// 	->with('lineas', $lineas)
		// 	->with('seccion', $plantilla->seccion)
		// 	->with('descripcion', $plantilla->descripcion)
		// 	->with('categories', $categories);
	}

	public function getPlantilla($plantilla_id)
	{
		$lineas =LineaPlantilla::where('plantilla_id',$plantilla_id)->orderBy('id', 'DESC')->get();
		$plantilla = Plantilla::where('id', $plantilla_id)->first();
		$restaurante = $plantilla->restaurante;
		$seccion = $plantilla->seccion;
		$descripcion = $plantilla->descripcion;
		$categories = Articulo::all();

		return view('plantillas.detalle')
			->with('plantilla_id', $plantilla_id)
			->with('restaurante', $restaurante)
			->with('lineas', $lineas)
			->with('seccion', $seccion)
			->with('descripcion', $descripcion)
			->with('categories', $categories);
	}

	public function borrarPlantilla($plantilla_id)
	{	
		$plantilla = Plantilla::where('id', $plantilla_id)->first();
		
		if (!$plantilla){
			return redirect()->back()->with('info', 'No se ha podido borrar...');
		}

		//COMPROBAR SI LA PLANTILLA ESTÁ VACÍA.
		$contenido = LineaPlantilla::where('plantilla_id', $plantilla_id)->first();
		if ($contenido){
			return redirect()->back()
				->with('info', 'NO SE PUEDE ELIMNAR. ¡¡¡ HAY QUE ELIMINAR EL DETALLE PRIMERO !!!');
		}
		//borrar la plantilla

		$plantilla->delete();

		return redirect()->back()
			->with('info', 'Plantilla eliminada!!!');
	}

	public function postLineaPlantilla(Request $request, $plantilla_id)
	{
		$this->validate($request, [
			'articuloId'=>'required',
		]);
		
		$lineaplantilla = LineaPlantilla::create([
			'plantilla_id'=>$plantilla_id,
			'articulo_codint' =>$_POST['articuloId'],
			]);
		// return view('home');
		
		return redirect()->back();
	}


	public function deleteLineaPlantilla ($lineaPlantillaId)
	{
		$lineaPlantilla = LineaPlantilla::where('id', $lineaPlantillaId)->first();

		$lineaPlantilla->delete();

		return redirect()->back();
	}
}