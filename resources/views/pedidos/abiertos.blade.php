@extends('templates.default')

@section('content')

	<div class="row">
	    <div class="col-lg-6">
	        <form role="form" action="{{route('pedidos.abiertos')}}" method="post">
	            <div class="form-group{{$errors->has('proveedorId') ? ' has-error' : ''}}">
	                <label for="proveedorId" class="control-label">Nuevo Pedido</label>
	                
					  <select class="form-control" id="proveedorId" name="proveedorId">
					  		<option value="">Elige un proveedor</option>
					    @foreach ($categories as $category)
					   		<option value="{{$category->id}}">{{$category->nombre}}</option>
					   	@endforeach
					  </select>
	  
	                @if ($errors->has('proveedorId'))
	                	<span class="help-block">{{$errors->first('proveedorId')}}</span>
	                @endif	                
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="btn btn-default">Crear Pedido</button>
	            </div>
	            <input type="hidden" name="_token" value="{{Session::token()}}">
	        </form>
	        <hr>
	    </div>
	</div>

	<div class="row">
	    <div class="col-lg-6">
	        @if (!$pedidos->count())
	        	<p>No hay nigún pedido abierto</p>
	        @else
	        	<table class="table table-striped">
				    <thead>
				    	<tr>
				    		<th>Fecha</th>
				        	<th>Proveedor</th>
				        	<th></th>
				        	<th></th>
				    	</tr>
				    </thead>
				    <tbody>
	        	@foreach ($pedidos as $pedido)
						<tr>
        					<td>{{$pedido->created_at->format('d-m-Y')}}</td>
        					<td>{{$pedido->proveedor->nombre}}</td>
        					<td>
        						<form action="{{route('pedidos.detalle',$pedido->id)}}" method="POST">
						             {{ csrf_field() }}
						            <button class="btn-primary">Detalle</button>
						        </form>
						    </td>
        					<td>
        						<form action="{{route('pedido.borrar',$pedido->id)}}" method="POST">
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
	
@stop
