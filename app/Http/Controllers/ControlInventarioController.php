<?php

namespace Pedidos\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Pedidos\Http\Requests;
use Pedidos\Models\Inventario;
use Pedidos\Models\LineaInventario;
use Pedidos\Models\LineaControlInventario;
use Pedidos\Models\ControlInventario;
use Pedidos\Http\Controllers\Controller;

class ControlInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('control.tablaControl');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {      
        
        $controles = ControlInventario::all();      
        $inventarios= Inventario::all();



        
        return view('control.crearControl', compact('inventarios','controles'));
        
    }

    public function createFiltrado($filtro)
    {      
        
        switch ($_GET[$filtro]) {
            case 'MARINA':
                $controles = ControlInventario::where('restaurante','MARINA')->get();
                break;
            case 'CORTES':
                $controles = ControlInventario::where('restaurante','CORTES')->get();
                break;
            case 'RACO':
                $controles = ControlInventario::where('restaurante','RACO')->get();
                break;
            default:
                $controles = ControlInventario::all();
        }

        $inventarios= Inventario::all();

        return view('control.crearControl', compact('inventarios','controles'));
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           
        $this->validate($request, [
            'descripcion' => 'required|min:4',
            'restaurante' => 'required',
            'inventario_inic' => 'required',
            'inventario_final' => 'required|different:inventario_inic',
        ]);
        $inventario_inic = Inventario::where('id',$request->inventario_inic)->first();
        $inventario_final = Inventario::where('id',$request->inventario_final)->first();
        
        $control = new ControlInventario;
        $control->restaurante = $request->restaurante;
        $control->inicial_id = $request->inventario_inic;
        $control->final_id = $request->inventario_final;
        $control->inicial_fecha = $inventario_inic->updated_at;
        $control->final_fecha = $inventario_final->updated_at;
        if($control->inicial_fecha > $control->final_fecha){
            return redirect()->back()->with('info', 'el informe final debe ser posterior');
        }
        $control->descripcion = $request->descripcion;
        $control->save();

        
        $lineasC = LineaInventario::where('inventario_id', $request->inventario_inic)->get()->toArray();
            foreach ($lineasC as $lineaC) {
                // dd($lineaC['articulo_codint']);

                $lineaEquivalenteFinal = LineaInventario::where('inventario_id', $control->final_id)
                    ->where('articulo_codint', $lineaC['articulo_codint'])->first();
                LineaControlInventario::insert([
                'controlInventarios_id'=> $control->id,
                'codigoArticulo_id' => $lineaC['articulo_codint'],
                'inicial_uds' => $lineaC['unidades'],
                'final_uds' => $lineaEquivalenteFinal->unidades,
                ]);
            }
        return redirect()->back()->with('info', 'Ya puedes completar el informe');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $control = ControlInventario::where('id', $id)->first();
        $lineas = LineaControlInventario::where('controlInventarios_id', $id)->get();
       
        return view('control.tablaControl', compact('control', 'lineas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $control = ControlInventario::where('id', $id)->first();
        $lineas = LineaControlInventario::where('controlInventarios_id', $id)->get();
        
        $totalInicial = $lineas->sum('inicial_uds');
        $totalEntradas = $lineas->sum('entradas');
        $totalVentas = $lineas->sum('ventas');
        $totalTeorico = $lineas->sum('teorico_uds');
        $totalFinal = $lineas->sum('final_uds');
        $totalDesviaciones = $lineas->sum('desviacion_uds');

        $totals = compact('totalInicial', 'totalEntradas', 'totalVentas', 'totalTeorico', 'totalFinal', 'totalDesviaciones');

        return view('control.tablaControlEditable', compact('control', 'lineas', 'totals'));
    

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(isset($_POST['salir'])){
            return redirect()->route('control.create');
        }
        
        $lineas =LineaControlInventario::where('controlInventarios_id',$id)->get();

        foreach ($lineas as $linea) {
            $lineaId=$linea->id;
            $cantidadCompra = "cantidadCompra"."_".$lineaId;
            $unidadesCompra = $request->input($cantidadCompra);
            $linea->entradas = $unidadesCompra;            
            $cantidadVenta = "cantidadVenta"."_".$lineaId;
            $unidadesVenta = $request->input($cantidadVenta);
            $linea->ventas = $unidadesVenta;
            $linea->teorico_uds = $linea->inicial_uds + $unidadesCompra - $unidadesVenta;
            $linea->desviacion_uds = $linea->final_uds - $linea->teorico_uds;
            $linea->desviacion_percent = $linea->desviacion_uds / $linea->teorico_uds;
            $linea->save();
        }

        //sumar columnas
        
        // $totalInicial = $lineas->sum('inicial_uds');
        // $totalEntradas = $lineas->sum('entradas');
        // $totalVentas = $lineas->sum('ventas');
        $totalTeorico = $lineas->sum('teorico_uds');
        // $totalFinal = $lineas->sum('final_uds'); 
        $totalDesviaciones = $lineas->sum('desviacion_uds');

        $promedio = $totalDesviaciones / $totalTeorico;
        $control = ControlInventario::where('id', $id)->first();
        $control->promedio = $promedio;
        $control->save();

        
        // otra forma
        // $promedio = DB::table('orders')->avg('price');
        return redirect()->back()->with('info', 'cambios guardados');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
