@extends('templates.default')

@section('content')

	<div class="row">
	    <h3>{{$restaurante}}</h3>
	    <div style="display: inline"><h3 style="display: inline">{{$seccion}} | Inventario nº {{$inventario_id}} | Asignado a: {{$inventario->user->username}}&nbsp;&nbsp;&nbsp;</h3></div>
	       	
	       	<div style="display: inline" class="center-block">
	   			<form style="display: inline" action="{{route('imprimir',$inventario->id)}}" method="GET">
	   			<button type="" class="btn btn-success">Imprimir</button>
	   			</form>
    		</div>&nbsp;&nbsp;&nbsp;
    		@if (!$lineas->count())
			

			<div style="display:inline"class="center-block">
			<form style="display: inline" action="{{route('inventario.borrar',$inventario->id)}}" method="POST">
	            {{ csrf_field() }}
	            {{ method_field('DELETE') }}
    		 	<button type="" class="btn btn-danger">Eliminar</button>
    		</form>
    		</div>&nbsp;&nbsp;&nbsp;
    		@endif


	       	<div style="display:inline"class="center-block">
	   			<a href="{{route('inventarios.admin')}}"><button type="button" class="btn btn-success" name="terminado">Volver</button></a>
    		</div>&nbsp;&nbsp;&nbsp;
			@if ($inventario->estado=='Pendiente')
			<form style="display: inline" action="{{route('inventarios.usuario', $inventario_id)}}" method="POST">
	            {{ csrf_field() }}	                		 	
    		 	<button type="submit" class="btn btn-success" name="terminado">ENVIAR a {{$inventario->user->username}}</button>
    		</form>
    		@endif

	</div>
	<hr>

	
	<div class="row">
	    <div class="col-sm-8">
	      	@if ($inventario->estado == 'Asignado' || $inventario->estado == 'Pendiente')
	        <form class="form-inline" role="form" action="{{route('lineaInventario.crear', $inventario_id)}}" method="post">
	            <div class="form-group{{$errors->has('articuloId') ? ' has-error' : ''}}">
	                
					  <select class="form-control" id="articuloId" name="articuloId">
					  		<option value="">Elige un artículo</option>
					    @foreach ($categories as $category)
					   		<option value="{{$category->codigo_interno}}">{{$category->codigo_interno}} - {{$category->nombre}}</option>
					   	@endforeach
					  </select> 	
	  
	                @if ($errors->has('articuloId'))
	                	<span class="help-block">{{$errors->first('articuloId')}}</span>
	                @endif	                
	            </div>
	            
	            &nbsp;&nbsp;&nbsp;
	            	<button type="submit" class="btn btn-primary">Añadir artículo</button>
	            
	            <input type="hidden" name="_token" value="{{Session::token()}}">
	        </form>
	       	@endif

	    </div>
	    

    </div>
    

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
        						@if ($inventario->estado == 'Pendiente' || $inventario->estado == 'Asignado')
        						<form action="{{route('lineaInventario.eliminar', $linea->id)}}" method="POST">
						             {{ csrf_field() }}
						             {{ method_field('DELETE') }}
						        <button class="btn-primary btn-danger">Eliminar Linea</button>
						        </form>
						        @else
						        <label for="">{{$linea->unidades}}</label>
						  		@endif
						    </td>						    
        					
     					 </tr>
	        	@endforeach
	        		</tbody>
 				</table>

	  			
	        @endif
				@if($inventario->estado == 'Cerrado')
 				<form action="{{route('inventarios.pendiente', $inventario_id)}}" method="POST">
	 				{{ csrf_field() }}
	 				<div class="checkbox">
	    				<label>
		    				<input type="checkbox" name="pendiente" id="pendiente" value="yes"> DESEO VOLVER A PONER PENDIENTE EL INVENTARIO
	    				</label>&nbsp;&nbsp;
	    				<button class="btn btn-primary" name="cambiarPendiente">Cambiar a Pendiente</button>
	  				</div>
	  			</form>
	  			@endif
	    </div>
	</div>

	
@stop
