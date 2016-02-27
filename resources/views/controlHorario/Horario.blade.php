@extends('templates.default')

@section('content')
<p>Página de usuarios/empleados</p>
<p>listado no editable de las peticiones de confirmación de horario</p>

<p>Tabla con las peticiones de confirmación</p>

<h2>Bordered Table</h2>
  <p>The .table-bordered class adds borders to a table:</p>            
  @if(!$lineas->count())
  <p>No hay ningún parte horario pendiente.</p>
  @else
	<table class="table table-bordered">
		<thead>
			<tr>
			<th>Fecha</th>
			<th>Entrada</th>
			<th>Salida</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($lineas as $linea)
			<tr>
			<td>{{$linea->fecha}}</td>
			<td>{{$linea->entrada}}</td>
			<td>{{$linea->salida}}</td>
			<td><a href="#">Confirmar</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
   @endif
@stop