@extends('templates.default')


@section('content')
<div class="container">

    <div style="" align="center">
        <button type="button" style="" class="btn btn-info" data-toggle="collapse" data-target="#nuevo">Nueva Plantilla</button>
        
    </div>
    <hr>
    <div id="nuevo" class="row collapse{{$errors->has('restaurante')||$errors->has('seccion')||$errors->has('descripcion') ? ' in' : ''}}">
        <div class="row">   
            <div class="col-lg-6">
                <form role="form" action="{{route('plantilla.nueva')}}" method="post">
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
                    <div class="form-group{{$errors->has('seccion') ? ' has-error' : ''}}">
                        <select class="form-control" id="seccion" name="seccion">
                            <option value="">Elige una Seccion</option>
                            <option value="VINOS" @if (old('seccion')=="VINOS") selected="selected" @endif>VINOS</option>
                            <option value="CHARCUTERIA" @if (old('seccion')=="CHARCUTERIA") selected="selected" @endif>CHARCUTERIA</option>
                            <option value="BARRA" @if (old('seccion')=="BARRA") selected="selected" @endif>BARRA</option>
                        </select>
                        @if ($errors->has('seccion'))
                            <span class="help-block">{{$errors->first('seccion')}}</span>
                        @endif                  
                    </div>
                    <div class="form-group{{$errors->has('descripcion') ? ' has-error' : ''}}">       
                        <label for="descripcion">DESCRIPCION</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control">
                        @if ($errors->has('descripcion'))
                            <span class="help-block">{{$errors->first('descripcion')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Crear Plantilla</button>
                    </div>
                    <input type="hidden" name="_token" value="{{Session::token()}}">
                </form>
                <hr>
            </div>  
        </div>
    </div>


    <div class="row">
        <div class="col-lg-8">
            @if (!$plantillas->count())
            	<p>No hay ninguna plantilla todavía</p>
            @else
            	<table class="table table-striped">
    			    <thead>
    			    	<tr>  		
        					<th>Restaurante</td>
                            <th>Seccion</th>   					
    			    		<th>Descripcion</th>
    			        	<th></th>
    			    	</tr>
    			    </thead>
    			    <tbody>
            	@foreach ($plantillas as $plantilla)
    					<tr>						
                            <td>{{$plantilla->restaurante}}</td>
        					<td>{{$plantilla->seccion}}</td>
        					<td>{{$plantilla->descripcion}}</td>
        					<td>
        						<form action="{{route('plantilla.detalle',$plantilla->id)}}" method="POST">
    					             {{ csrf_field() }}
    					            <button class="btn-primary">Detalle <span class="badge">{{$plantilla->lineas->count()}}</span></button>
    					        </form>
    					    </td>
        					<td>
        						<form action="{{route('plantilla.borrar',$plantilla->id)}}" method="POST">
    					            {{ csrf_field() }}
    					            {{ method_field('DELETE') }}
    					            <button class="btn-danger">Eliminar</button>
    					        </form>
        						
        					</td>
        					
     					 </tr>
            	@endforeach
            		</tbody>
    				</table>
            @endif
        </div>
    </div>
</div>

	
@stop
