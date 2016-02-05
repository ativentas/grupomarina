@extends('templates.default')

@section('content')

	<div class="row">
	    <h3>{{$restaurante}}</h3>
	    <h3>{{$seccion}} | Plantilla: {{$descripcion}}</h3> 
	</div>
	<div class="row">
	    <div class="col-sm-8">
	      
	        <form class="form-inline" role="form" action="{{route('lineaPlantilla.crear', $plantilla_id)}}" method="post">
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

	       
	        <hr>
	    </div>

	    <div class="col-sm-1">
		   <a href="{{route('inventarios.admin')}}"><button type="button" class="btn btn-success">Terminado</button></a>
	    </div>
    </div>


	<div class="row">
	
	    <div class="col-lg-8">
	        @if (!$lineas->count())
	        	<p>Esta plantilla está vacía todavía</p>
	        @else
	        	<table class="table table-striped">
				    <thead>
				    	<tr>
				    		<th>CÓDIGO</th>
				        	<th>NOMBRE</th>
				    	</tr>
				    </thead>

				    <tbody>
	        	@foreach ($lineas as $linea)
						<tr>
        					<td>{{$linea->articulo_codint}}</td>
        					<td>{{$linea->articulo->nombre}}</td>
        					<td>
        					
        						<form action="{{route('lineaPlantilla.borrar',$linea->id)}}" method="POST">
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
