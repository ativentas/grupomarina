@extends('templates.defaultImprimir')

@section('content')

	<div class="">
	    <h3>{{$restaurante}}</h3>
	    <h3 style="">{{$seccion}} | Inventario nº {{$inventario_id}} | Operario: {{$inventario->user->username}}&nbsp;&nbsp;&nbsp;</h3>
	       	
	</div>
	<hr> 
	<div class="">	
	    <div class="">
	        @if (!$lineas->count())
	        	<p>Este inventario está vacío.</p>
	        @else
	        	<table class="">
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
        					<td><label for="">{{$linea->unidades}}</label>						  		
						    </td>						           					
     					 </tr>
	        	@endforeach
	        		</tbody>
 				</table>	  			
	        @endif				
	    </div>
	</div>

	
@stop
