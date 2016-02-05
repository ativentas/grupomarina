@extends('templates.default')

@section('content')

	<div class="row">
	    <h3>{{$restaurante}}</h3>
	    <h3>{{$seccion}} | Inventario nº {{$inventario_id}} | Asignado a: {{$inventario->user->username}}</h3>
	</div>


	@if(Auth::user()->isAdmin())
	<div class="row">
	    <div class="col-sm-8">
	      	@if ($inventario->estado == 'Pendiente')
	        <form class="form-inline" role="form" action="{{route('lineaInventario.crear', $inventario_id)}}" method="post">
	            <div class="form-group{{$errors->has('articuloId') ? ' has-error' : ''}}">
	                
					  <select class="form-control" id="articuloId" name="articuloId">
					  		<option value="">Añade un artículo</option>
					    @foreach ($categories as $category)
					   		<option value="{{$category->codigo_interno}}">{{$category->codigo_interno}} - {{$category->nombre}}</option>
					   	@endforeach
					  </select>
	  
	                @if ($errors->has('articuloId'))
	                	<span class="help-block">{{$errors->first('articuloId')}}</span>
	                @endif	                
	            </div>
	            
	            <div class="form-group">
	            	<button type="submit" class="btn btn-default">Añadir producto</button>
	            </div>
	            <input type="hidden" name="_token" value="{{Session::token()}}">
	        </form>
	       	@endif
	        <hr>
	    </div>
	    
	    <div class="col-sm-1">
	   		<a href="{{route('inventarios.admin')}}"><button type="button" class="btn btn-success">Volver</button></a>
    	</div>
    </div>
    @endif

	<div class="row">
	
	    <div class="col-lg-8">
	        @if (!$lineas->count())
	        	<p>Este inventario está vacío.</p>
	        @else
	        	<table class="table table-striped">
				    <thead>
				    	<tr>
				    		<th>CÓDIGO</th>
				        	<th>NOMBRE</th>
				        	@if ($inventario->estado == 'Cerrado')
				        	<th>UNIDADES</th>
				        	@endif
				    	</tr>
				    </thead>

				    <tbody>

	        	@foreach ($lineas as $linea)
						<tr>
        					<td>{{$linea->articulo_codint}}</td>
        					<td>{{$linea->articulo->nombre}}</td>
        					<td>		
        						@if (Auth::user()->isAdmin() && $inventario->estado == 'Pendiente')
        						<form action="{{route('lineaInventario.eliminar', $linea->id)}}" method="POST">
						             {{ csrf_field() }}
						             {{ method_field('DELETE') }}
						        <button class="btn-primary btn-danger">Eliminar</button>
						        </form>
						        @else
						        <label for="">{{$linea->unidades}}</label>
						  		@endif
						    </td>						    
        					
     					 </tr>
	        	@endforeach
	        		</tbody>
 				</table>
 				<!-- yo creo que el if siguiente se puede borrar, pq esta vista es solo para el admin -->
 				@if (!Auth::user()->isAdmin())

 				<form action="{{route('inventarios.completo', $inventario_id)}}" method="POST">
	 				{{ csrf_field() }}
	 				<div class="checkbox">
	    				<label>
		    				<input type="checkbox" name="completado" id="completado" value="yes"> INVENTARIO COMPLETADO
	    				</label>
	    				<button class="btn-primary">Enviar Oficina</button>
	  				</div>
	  			</form>
	  			@endif
	        @endif
	    </div>
	</div>
	
@stop
