@extends('templates.default')

@section('content')


<h2>{{$cuadrante->fecha->format('d/m/Y')}}</h2>

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
			<form action="{{route('cuadrante.requerir', $cuadrante->id)}}" method="POST">
			{{csrf_field()}}
			<td>{{$linea->empleado->nombre_completo}}</td>
			<td>
			@if ($linea->horaEntradaM == null)
			<input type="time" name="entrada" id="entrada" value="">
			@else
			<input type="time" name="entrada" id="entrada" value={{date('H:i',strtotime($linea->horaEntradaM))}}>
			@endif</td>
			<td>
			@if ($linea->horaSalidaM == null)
			<input type="time" name="salida" id="salida" value="">
			@else
			<input type="time" name="salida" id="salida" value={{date('H:i',strtotime($linea->horaSalidaM))}}>
			@endif</td>
			<td><p class="bg-success small">{{$linea->asunto}}</p></td>
			<td>{{$linea->empleado->email}}</td>
			<td><button type="submit" name="requerir" value={{$linea->id}}>Requerir</button></form></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<button type="submit">Guardar</button>

  


@stop