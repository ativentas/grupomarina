@extends('templates.default')

@section('content')

<div class="row col-md-12">
    
    <div class="col-md-4 form-group">
        <select class="form-control" id="restaurante" name="restaurante">
            <option value="">RTE: TODOS</option>
            <option value="MARINA">MARINA</option>
            <option value="CORTES">CORTES</option>
            <option value="RACO">RACO</option>
        </select>                  
    </div>
    <button type="button" class=btn>Filtrar</button>
    <button type="button" class="btn btn-info col-md-offset-1" data-toggle="collapse" data-target="#nuevo">Nuevo Control</button>
    <hr>
    
    <div id="nuevo" class="row col-md-6 col-md-offset-3 collapse{{$errors->count()>0 ? ' in' : ''}}">

    <form role="form" action="{{route('control.store')}}" method="post">
            
            <div class="form-group{{$errors->has('restaurante') ? ' has-error' : ''}}">
                <select class="form-control" id="restaurante" name="restaurante">
                    <option value="">Elige un Restaurante</option>
                    <option value="MARINA" @if (old('restaurante')=="MARINA") selected="selected" @endif>MARINA</option>
                    <option value="CORTES" @if (old('restaurante')=="CORTES") selected="selected" @endif>CORTES</option>
                    <option value="RACO" @if (old('restaurante')=="RACO") selected="selected" @endif>RACO</option>
                </select>
                @if ($errors->has('restaurante'))
                    <span class="help-block">{{$errors->first('restaurante')}}</span>
                @endif                  
            </div>

            <div class="form-group{{$errors->has('inventario_inic') ? ' has-error' : ''}}">       
                <select class="form-control" id="inventario_inic" name="inventario_inic">
                    <option value="">Elige Inventario Inicial</option>                      
                    @foreach ($inventarios as $inventario)                        
                        <option value="{{$inventario->id}}" @if (old('inventario_inic')==$inventario->id) selected="selected" @endif>{{$inventario->descripcion}}</option>
                    @endforeach
                </select>
                @if ($errors->has('inventario_inic'))
                    <span class="help-block">{{$errors->first('inventario_inic')}}</span>
                @endif
            </div>

            <div class="form-group{{$errors->has('inventario_final') ? ' has-error' : ''}}">      
                <select class="form-control" id="inventario_final" name="inventario_final">
                    <option value="">Elige Inventario Final</option>                      
                    @foreach ($inventarios as $inventario)                        
                        <option value="{{$inventario->id}}" @if (old('inventario_inic')==$inventario->id) selected="selected" @endif>{{$inventario->descripcion}}</option>
                    @endforeach
                </select>
                @if ($errors->has('inventario_final'))
                    <span class="help-block">{{$errors->first('inventario_final')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('descripcion') ? ' has-error' : ''}}">
                <label for="descripcion" class="control-label">Descripción</label>
                <input type="text" autocomplete="off" name="descripcion" class="form-control" id="descripcion" value="{{Request::old('descripcion') ?: ''}}">
                @if ($errors->has('descripcion'))
                    <span class="help-block">{{$errors->first('descripcion')}}</span>
                @endif
            </div>
        
            <div class="form-group">
                <button type="submit" name="crear" class="btn btn-default">Crear Control Inventario</button>
            </div>
            <input type="hidden" name="_token" value="{{Session::token()}}">
        </form>

</div>
</div>

<div class="row">

<div id="col-md-8 no-more-tables">
    <table class="col-md-12 table-bordered table-striped table-condensed cf">
        <thead class="cf">
            <tr class="bg-success">
                <th class="col-md-2">RESTAURANTE.</th>
                <th class="col-md-5">DESCRIPCION.</th>
                <th class="col-md-1">FECHA.</th>
                <th class="col-md-1 numeric">DESV.</th>
                <th class="col-md-1"></th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-md-2"></td>
                <td class="col-md-5"></td>
                <td class="col-md-1"></td>
                <td class="col-md-1"></td>
                <td class="col-md-1"><button type="button" class="btn">Ver</button></td>
                
            </tr>
        </tbody>
    </table>
</div>
</div>





@stop