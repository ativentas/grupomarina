@extends('templates.default')

@section('content')



	<div class="row">
	    <div class="col-lg-8">
	        @if (!$pedidos->count())
	        	<p>No hay nigún pedido completado</p>
	        @else
	        	<table class="table table-striped">
				    <thead>
				    	<tr>
				    		@if (Auth::user()->isAdmin())
        					<th>Restaurante</td>
        					@endif
				    		<th>Fecha</th>
				        	<th>Proveedor</th>
				        	<th></th>
				        	<th></th>
				    	</tr>
				    </thead>
				    <tbody>
	        	@foreach ($pedidos as $pedido)
						<tr>
        					@if (Auth::user()->isAdmin())
        					<td>{{$pedido->restaurante}}</td>
        					@endif
        					<td>{{$pedido->created_at->format('d-m-Y')}}</td>
        					<td>{{$pedido->proveedor->nombre}}</td>
        					<td>
        						<form action="{{route('pedidos.detalle',$pedido->id)}}" method="POST">
						             {{ csrf_field() }}
						            <button class="btn-primary">Detalle</button>
						        </form>
						    </td>
        					<td>
        						@if (Auth::user()->isSupervisor())
				 				<form action="{{route('pedidos.descompletado', $pedido->id)}}" method="POST">
		 							<div class="checkbox">
	    								<label><input type="checkbox" name="descompletado" id="descompletado"> Marca para modificar</label>
					    				<button class="btn-primary">Modificar</button>
					  				</div>
	  								{{ csrf_field() }}
					  			</form>
					  			@endif
        
        						
        					</td>
        					
     					 </tr>
	        	@endforeach
	        		</tbody>
 				</table>
	        @endif
	    </div>
	</div>
	
@stop
