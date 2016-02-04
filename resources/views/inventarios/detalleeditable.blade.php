@extends('templates.default')

@section('content')

	<div class="row">

	    <h3>{{$restaurante}}</h3>
	    <h3>{{$seccion}} | Inventario nº {{$inventario_id}} | Asignado a: {{$inventario->user->username}} | Completado: {{$inventario->updated_at->format('d-m-Y h:m')}}</h3>
	</div>

	<div class="row">
	
	    <div class="col-lg-8">
	        @if (!$lineas->count())
	        	<p>Este inventario está vacío.</p>
	        @else
	        	
	        	<form action="{{route('inventarios.completo', $inventario_id)}}" method="POST">
	 				{{ csrf_field() }}
				@if ($inventario->estado == 'Pendiente')
				<button class="btn-primary" name="cambios">Guardar Cambios</button>
	        	@endif
	        	<table class="table table-striped">
				    <thead>
				    	<tr>
				    		<th>CÓDIGO</th>
				        	<th>NOMBRE</th>
				        	<th>UNIDADES</th>
				    	</tr>
				    </thead>

				    <tbody>

	        	@foreach ($lineas as $linea)				

						<tr>
	    					<td>{{$linea->articulo_codint}}</td>
	    					<td>{{$linea->articulo->nombre}}</td>
	    					<td>
	    						@if ($inventario->estado == "Cerrado")
	    						{{$linea->unidades}}
	    						@endif		
	    						@if ($inventario->estado == "Pendiente")					            
	        					<input type="number" maxlength= "5" name="cantidad_{{$linea->id}}" value={{$linea->unidades}}>
						  		@endif
						    </td>
	    					
	 					 </tr>
	        	@endforeach
	        		</tbody>
 				</table>
 					@if ($inventario->estado == 'Pendiente')		
	 				<div class="checkbox">
	    				<label>
		    				<input type="checkbox" name="completado" id="completado" value="yes"> INVENTARIO COMPLETADO
	    				</label>
	    				<button class="btn-primary" name="oficina">Enviar Oficina</button>
	  				</div>
	  				@endif
	  			</form>
	  			
	        @endif
	    </div>
	</div>
	
@stop
