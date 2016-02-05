@extends('templates.default')

@section('content')
<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#nuevo">Nuevo Inventario</button>
<hr>
<div id="nuevo" class="row collapse{{$errors->has('plantillaId')||$errors->has('empleadoId')||$errors->has('restaurante') ? ' in' : ''}}">
	
    <div id="" class="col-lg-6">
        <form role="form" action="{{route('inventario.crear')}}" method="post">
            <div class="form-group{{$errors->has('plantillaId') ? ' has-error' : ''}}">
                <!-- <label for="plantillaId" class="control-label">Nuevo Inventario</label> -->       
				<select class="form-control" id="plantillaId" name="plantillaId">
					<option value="">Elige una plantilla</option>
					<option value="BLANCO" @if (old('plantillaId')=="BLANCO") selected="selected" @endif>Plantilla en Blanco</option>						
					@foreach ($plantillas as $plantilla)						
						<option value="{{$plantilla->id}}" @if (old('plantillaId')==$plantilla->id) selected="selected" @endif>{{$plantilla->descripcion}}</option>
					@endforeach
				</select>
                @if ($errors->has('plantillaId'))
                	<span class="help-block">{{$errors->first('plantillaId')}}</span>
                @endif
			</div>
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
			<div class="form-group{{$errors->has('empleadoId') ? ' has-error' : ''}}">       
				<select class="form-control" id="empleadoId" name="empleadoId">
					<option value="">Elige un empleado</option>
					@foreach ($empleados as $empleado)
						<option value="{{$empleado->id}}" @if (old('empleadoId')==$empleado->id) selected="selected" @endif>{{$empleado->username}}</option>
					@endforeach
				</select>
                @if ($errors->has('empleadoId'))
                	<span class="help-block">{{$errors->first('empleadoId')}}</span>
                @endif
			</div>
            <div class="form-group">
            	<button type="submit" name="crear" class="btn btn-default">Crear Inventario</button>
            </div>
            <input type="hidden" name="_token" value="{{Session::token()}}">
        </form>
        <hr>
    </div>
	
</div>

<div class="row">
    <div class="col-lg-6">
        @if (!$inventariosPendientes->count())
        	<p>No hay nigún inventario pendiente de recibir</p>
        @else
			
        	<h2>Inventarios Pendientes</h2>
        	<table class="table table-striped">
			    <thead>
			    	<tr>  		
    					<th>Restaurante</td>   					
			    		<th>Fecha Creacion</th>
			        	<th>empleado</th>
			        	<th></th>
			        	<th></th>
			    	</tr>
			    </thead>
			    <tbody>
        	@foreach ($inventariosPendientes as $inventario)
					<tr>						
    					<td>{{$inventario->restaurante}}</td>  					
    					<td>{{$inventario->created_at->format('d-m-Y H:i')}}</td>
    					<td>{{$inventario->user->username}}</td>
    					<td>
    						<form action="{{route('inventarios.detalle',$inventario->id)}}" method="POST">
					             {{ csrf_field() }}
					            <button class="btn-primary">Detalle <span class="badge">{{$inventario->lineas->count()}}</span></button>
					        </form>
					    </td>
    					<td>
    						<form action="{{route('inventario.borrar',$inventario->id)}}" method="POST">
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

<div class="row">
    <div class="col-lg-8">
        @if (!$inventariosCerrados->count())
        	
        @else		
        	<h2>Inventarios Terminados</h2>
        	<table class="table table-striped">
			    <thead>
			    	<tr>  		
    					<th>Restaurante</td>   					
			    		<th>Fecha Recibido</th>
			        	<th>empleado</th>
			        	<th></th>
			        	<th></th>
			    	</tr>
			    </thead>
			    <tbody>
        	@foreach ($inventariosCerrados as $inventario)
					<tr>						
    					<td>{{$inventario->restaurante}}</td>  					
    					<td>{{$inventario->updated_at->format('d-m-Y | H:i')}}</td>
    					<td>{{$inventario->user->username}}</td>
    					<td>
    						<form action="{{route('inventarios.detalle',$inventario->id)}}" method="POST">
					             {{ csrf_field() }}
					            <button class="btn-primary">Detalle <span class="badge">{{$inventario->lineas->count()}}</span></button>
					        </form>
					    </td>
    					<td>
    						<form action="{{route('inventario.borrar',$inventario->id)}}" method="POST">
					            {{ csrf_field() }}
					            {{ method_field('DELETE') }}
					            <button class="btn-danger">Eliminar</button>
					        </form>
    					</td>
    					<td>
    						<form action="{{route('inventarios.fichero',$inventario->id)}}" method="POST">
					             {{ csrf_field() }}
					            <button class="btn-primary">Fichero </button>
					        </form>
					    </td>
    					
 					 </tr>
        	@endforeach
        		</tbody>
				</table>
        @endif
    </div>
</div>	
@stop
