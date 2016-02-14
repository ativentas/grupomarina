@extends('templates.default')

@section('content')

	<div class="row">
	    <h3 style="display:inline"><span class="label label-default">Restaurante: {{$restaurante}}</span></h3>
	    <h3 style="display:inline"><span class="label label-default">Sección: {{$seccion}}</span></h3>
	    <h3> <span class="label label-primary">Plantilla: {{$descripcion}}</span></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	</div>
	
	
    <div class="row">
      
        <form class="form-inline" role="form" action="{{route('lineaPlantilla.crear', $plantilla_id)}}" method="post">
            <div class="form-group{{$errors->has('articuloId') ? ' has-error' : ''}}">
                
				  <select class="form-control" id="articuloId" name="articuloId">
				  		<option value="">Elige artículo</option>
				    @foreach ($categories as $category)
				   		<option value="{{$category->codigo_interno}}">{{$category->codigo_interno}} - {{$category->nombre}}</option>
				   	@endforeach
				  </select>

  
                @if ($errors->has('articuloId'))
                	<span class="help-block">{{$errors->first('articuloId')}}</span>
                @endif	                
            </div>
            
            &nbsp;&nbsp;&nbsp;
        	<button type="submit" class="btn btn-primary">Añadir Artículo</button>					            	
            
            <input type="hidden" name="_token" value="{{Session::token()}}">
			
			&nbsp;&nbsp;&nbsp;
    		<div style="display: inline" class="">
	    	<a href="{{route('plantillas.admin')}}"><button type="button" class="btn btn-success">Vover</button></a>
	    </div> 
        </form>


       
        <hr>
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
						            <button class="btn-danger">Borrar Linea</button>
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
