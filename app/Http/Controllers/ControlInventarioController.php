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
        
        $inventarios= Inventario::all();

        return view('control.crearControl', compact('inventarios'));
        
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
        $control->final_fecha = $inventario_final->updated_at;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
