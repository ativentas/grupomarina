<?php

namespace Pedidos\Http\Controllers;

use Auth;
use Pedidos\Models\User;
use Pedidos\Models\Pedido;
use Pedidos\Models\Linea;
use Pedidos\Models\Proveedor;
use Pedidos\Models\Articulo;
use Illuminate\Http\Request;

class PedidoController extends Controller
{

	public function getAbiertos()
	{
		$pedidos = Pedido::abiertos()
		->where
		(
			function($query) {
				return $query->where('restaurante', Auth::user()->restaurante);
			}
		)->orderBy('created_at', 'desc')->get();
		// dd($pedidos);

		$categories = Proveedor::all();
		// dd($categories);
		
		if(Auth::user()->isAdmin()){
			$pedidos = Pedido::abiertos()->orderBy('created_at', 'desc')->get();
		}
		return view('pedidos.abiertos')->with('pedidos', $pedidos)->with('categories', $categories);
	}

	public function getCompletos()
	{
		$pedidos = Pedido::cerrados()
		->where
		(
			function($query) {

				return $query->where('restaurante', Auth::user()->restaurante);
			}
		)->orderBy('updated_at', 'desc')->get();
		
		if(Auth::user()->isAdmin()){
			$pedidos = Pedido::cerrados()->orderBy('updated_at', 'desc')->get();
		}
		
		return view('pedidos.completos')->with('pedidos', $pedidos);

	}
	
	public function postPedido(Request $request)
	{

		$this->validate($request, [
			'proveedorId'=>'required',
		]);
		// Averiguar cómo acabar este if
		// if($request->get('proveedorId')=='un código ya utilizado en los abiertos de este restaurante')
		// 	return redirect()->back()->with('info','Ya tienes un pedido abierto con este proveedor');
		
		$pedidoexistente = Pedido::abiertos()
			->where('restaurante', Auth::user()->restaurante)
			->where('provider_id', $request->input('proveedorId') );
		
		if($pedidoexistente->count()){
			return redirect()->back()->with('info','ya hay un pedido abierto para ese proveedor');
		}

		Auth::user()->pedidos()->create([
			'provider_id' => $request->input('proveedorId'),
			'restaurante' => Auth::user()->restaurante,
		]);

		return redirect()->route('pedidos.abiertos')->with('info', 'Pedido Creado');
	}

	public function deletePedido($pedido_id)
	{
		
		$pedido = Pedido::abiertos()->where('id', $pedido_id)->first();
		// dd($pedido);
		if (!$pedido){
			return redirect()->back()->with('info', 'No se ha podido borrar...');
		}

		//COMPROBAR SI EL PEDIDO ESTÁ VACÍO.
		$contenido = Linea::where('pedido_id', $pedido_id)->first();
		if ($contenido){
			return redirect()->back()
				->with('info', 'NO SE PUEDE ELIMNAR. ¡¡¡ HAY QUE ELIMINAR LOS PRODUCTOS PRIMERO !!!');
		}
		//borrar el pedido

		$pedido->delete();

		return redirect()->back()
			->with('info', 'Pedido eliminado!!!');
	}

	public function getDetalle($pedido_id)
	{
		
		// dd($pedido_id);
		$pedido = Pedido::where('id', $pedido_id)->first();
		// dd($pedido->provider_id);
		$proveedor = Proveedor::where('id', $pedido->provider_id)->first();
		// dd($proveedor);
		$categories = Articulo::where('provider_id', $pedido->provider_id)->get();
		// dd($categories);
		$lineas =Linea::where('pedido_id',$pedido->id)->get();
			// dd($lineas);
		return view('pedidos.detalle')
			->with('pedido', $pedido)
			->with('proveedor', $proveedor)
			->with('categories', $categories)
			->with('lineas', $lineas)
			;
	}

	public function postLinea (Request $request, $pedido_id)
	{
		$this->validate($request, [
			'articuloId'=>'required',
		]);
	
		Auth::user()->lineas()->create([
			'article_id' => $request->input('articuloId'),
			'pedido_id' => $pedido_id,
			'cantidad' => $request->input('cantidad'),
		]);

		return redirect()->back();

	}

	public function deleteLinea ($lineaId)
	{
		$linea = Linea::where('id', $lineaId)->first();

		$linea->delete();

		return redirect()->back()	;
	}

	public function actualizarLinea (Request $request, $lineaId)
	{
		$linea = Linea::where('id', $lineaId)->first();
		$cantidad = $request->input('cantidad');
		$linea->cantidad = $cantidad;
		$linea->save();

		return redirect()->back();
	}

	public function postCompletado (Request $request, $pedido_id)
	{
		$this->validate($request, [
			'completado' =>'required',
		]);
		$pedidocompletado = Pedido::where('id', $pedido_id)->first();
		$estado = 'Lanzado';
		$pedidocompletado->estado = $estado;
		$pedidocompletado->save();

		return redirect()->back();
	}

	public function postDescompletado (Request $request, $pedido_id)
	{
		$this->validate($request, [
			'descompletado' =>'required',
		]);
		$pedidocompletado = Pedido::where('id', $pedido_id)->first();
		$estado = 'Abierto';
		$pedidocompletado->estado = $estado;
		$pedidocompletado->save();

		return redirect()->back()->with('info', 'El pedido se ha abierto, ya puedes modificarlo, pero solo porque eres supervisor');
	}

}
