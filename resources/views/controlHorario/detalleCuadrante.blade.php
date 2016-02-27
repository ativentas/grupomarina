@extends('templates.default')

@section('content')


<h2>{{$cuadrante->fecha->format('d/m/Y')}}</h2>
<form>       
	<table class="table table-bordered">
		<thead>
			<tr>
			<th>Empleado</th>
			<th>Entrada</th>
			<th>Salida</th>
			<th>Confirmacion</th>
			<th>email</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($lineas as $linea)
			<tr>
			<td>{{$linea->empleado->nombre_completo}}</td>
			<td>{{$linea->horaEntradaM}}</td>
			<td>{{$linea->horaSalidaM}}</td>
			<td>{{$linea->mensaje_id}}</td>
			<td>{{$linea->empleado->email}}</td>
			<td><a href="#">Ver</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<button type="submit">Guardar</button>
</form>  
  


@stop