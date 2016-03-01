@extends('templates.default')

@section('content')

<h3>Crear nuevo o consultar</h3>

<div class="col-sm-4 row">
<form role="form" action="{{route('cuadrante.generar')}}" method="post">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="fecha">Fecha</label>
    <input type="date" name="fecha" class="form-control" id="fecha" value={{date('d-m-Y')}}>
  </div>
  
	<div class="form-group">
	    <!-- <label for="empresa" class="control-label">Elegir Empresa</label> -->
	    <select class="form-control" id="empresa" name="empresa">
	        <option>Elige una Empresa</option>
	        <option>COSTASERVIS</option>
	        <option>VILA MOEMA</option>
	    </select>
	</div>

  <button type="submit" class="btn btn-default">Generar</button>
</form>
</div>


<div class="col-sm-12 row">
<h3>Ultimos Cuadrantes</h3>


<table class="table table-bordered">
	<thead>
		<tr>
		<th>Fecha</th>
		<th>Empresa</th>
		<th>Estado</th>
		<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($cuadrantes as $cuadrante)
		<tr>
		<td>{{$cuadrante->fecha->format('d-m-Y')}}</td>
		<td>{{$cuadrante->empresa}}</td>
		<td>{{$cuadrante->estado}}</td>
		<td><a href="{{route('cuadrante.detalle',$cuadrante->id	)}}">Detalle</a></td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>





@stop