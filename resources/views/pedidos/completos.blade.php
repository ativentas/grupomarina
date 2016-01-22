@extends('templates.default')

@section('content')



	<div class="row">
	    <div class="col-lg-6">
	        @if (!$pedidos->count())
	        	<p>No hay nigún pedido lanzado</p>
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
        						@if (Auth::user()->isSupervisor())
        						<form action="{{route('pedido.borrar',$pedido->id)}}" method="POST">
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
	        @endif
	    </div>
	</div>
	
@stop
