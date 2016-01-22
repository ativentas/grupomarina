@extends('templates.default')

@section('content')

	<div class="row">
	    <h3>{{$pedido->proveedor->nombre}} | Pedido nº {{$pedido->id}} | Fecha: {{$pedido->created_at->format('d-m-Y')}} </h3>
	    <div class="col-sm-8">
	        @if ($pedido->estado == 'Abierto')
	        <form class="form-inline" role="form" action="{{route('linea.crear', $pedido->id)}}" method="post">
	            <div class="form-group{{$errors->has('articuloId') ? ' has-error' : ''}}">
	                
					  <select class="form-control" id="articuloId" name="articuloId">
					  		<option value="">Añade un artículo</option>
					    @foreach ($categories as $category)
					   		<option value="{{$category->id}}">{{$category->nombre}}</option>
					   	@endforeach
					  </select>
	  
	                @if ($errors->has('articuloId'))
	                	<span class="help-block">{{$errors->first('articuloId')}}</span>
	                @endif	                
	            </div>
	            <div class="form-group">
	            	<input type="text" name="cantidad" id="cantidad" placeholder="Cantidad">
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="btn btn-default">Añadir producto</button>
	            </div>
	            <input type="hidden" name="_token" value="{{Session::token()}}">
	        </form>
	        @endif
	        <hr>
	    </div>
	</div>

	<div class="row">
	    <div class="col-lg-8">
	        @if (!$lineas->count())
	        	<p>Este pedido está vacío todavía</p>
	        @else
	        	<table class="table table-striped">
				    <thead>
				    	<tr>
				    		<th>CÓDIGO</th>
				        	<th>NOMBRE</th>
				        	<th>PRECIO</th>
				        	<th>MEDIDA</th>
				        	<th>CANTIDAD</th>
				        	<th></th>
				        	<th></th>

				    	</tr>
				    </thead>
				    <tbody>
	        	@foreach ($lineas as $linea)
						<tr>
        					<td>{{$linea->articulo['codigo_interno']}}</td>
        					<td>{{$linea->articulo['nombre']}}</td>
        					<td>{{$linea->articulo['precio']}}</td>
        					<td>{{$linea->articulo['medida']}}</td>

        					<td>
        						@if ($pedido->estado == 'Abierto')
	        						<form action="{{route('linea.actualizar',$linea->id)}}" method="POST">
							             {{ csrf_field() }}
							            <button class="btn-primary">Actualizar</button>
	            					<td><input type="text" name="cantidad" value={{$linea->cantidad}}></td>
							        </form>
						        @endif
						    </td>
        					<td>
        						@if ($pedido->estado == 'Abierto')
        						<form action="{{route('linea.borrar',$linea->id)}}" method="POST">
						            {{ csrf_field() }}
						            {{ method_field('DELETE') }}
						            <button class="btn-danger">Eliminar</button>
						        </form>
        						@endif
        					</td>
        					
     					 </tr>
	        	@endforeach
	        		</tbody>
 				</table>
 				@if ($pedido->estado =='Lanzado')
 					<p>El pedido ya esta Lanzado</p>
 				@elseif ($pedido->estado =='Abierto')
	 				<form action="{{route('pedidos.completado', $pedido->id)}}" method="POST">
		 				{{ csrf_field() }}
		 				<div class="checkbox">
		    				<label><input type="checkbox" name="completado" id="completado"> Marca aquí si el pedido está completo.</label>
		    				<button class="btn-primary">Completo!</button>
		  				</div>
		  			</form>
				@endif

	        @endif
	    </div>
	</div>
	
@stop
