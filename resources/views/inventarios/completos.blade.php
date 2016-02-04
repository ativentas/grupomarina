@extends('templates.default')

@section('content')
<div class="panel panel-warning">
<div class="panel-heading">Ultimos Inventarios completados</div>
</div>
	<div class="row">
	    <div class="col-lg-6">
	        @if (!$inventarios->count())
	        	<p>No hay nigún inventario completado</p>
	        @else
	        	<table class="table table-striped">
				    <thead>
				    	<tr>				    		
        					<th>Restaurante</td>       					
				    		<th>Fecha</th>
				        	<th></th>
				    	</tr>
				    </thead>
				    <tbody>
	        	@foreach ($inventarios as $inventario)
						<tr>
        					<td>{{$inventario->restaurante}}</td>        					
        					<td>{{$inventario->updated_at->format('d-m-Y')}}</td>
        					<td>
        						<form action="{{route('inventarios.detalle',$inventario->id)}}" method="POST">
						             {{ csrf_field() }}
						            <button class="btn-primary">Ver Inventario</button>
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
