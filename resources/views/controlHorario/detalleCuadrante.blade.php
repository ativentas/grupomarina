@extends('templates.default')

@section('content')


<h3>Parte Horario. Fecha: {{$cuadrante->fecha->format('d/m/Y')}} - Empresa: {{$cuadrante->empresa}}</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
			<th>Empleado</th>
			<th style = "">Entrada</th>
			<th style = "">Salida</th>
			<th>Confirmacion</th>
			<th>email</th>

			</tr>
		</thead>
		<tfoot>
			<tr>
				<td style="visibility:hidden;"></td>
				<td colspan="2"><button type="submit">Actualizar Horas</button></td>
				<td style="visibility:hidden;"></td>
				<td colspan="2"><div class=""><button type="submit" name="requerir" value=0>Requerir TODOS</button></div></td>
			</tr>
		</tfoot>

		<tbody>
			@foreach ($lineas as $linea)
			<tr>
			<form action="{{route('cuadrante.requerir', $cuadrante->id)}}" method="POST">
			{{csrf_field()}}
			<td>{{$linea->empleado->nombre_completo}}</td>
			<td class="">
			@if ($linea->entrada == null)
			<input type="text" name="entrada" id="entrada" size="5" value="">
			@else
			<input type="text" name="entrada" id="entrada" size="5" value={{date('H:i',strtotime($linea->entrada))}}>
			@endif
			@if ($linea->turno_partido == 1)
			<br><input type="text" size="5" name="entrada2" id="entrada2" value="{{$linea->entrada2 ? date('H:i',strtotime($linea->entrada2)) : ''}}">
			@endif
			</td>
			<td>
			@if ($linea->salida == null)
			<input type="text" size="5" name="salida" id="salida" value="">
			@else
			<input type="text" size="5" name="salida" id="salida" value={{date('H:i',strtotime($linea->salida))}}>
			@endif
			@if ($linea->turno_partido == 1)
			<br><input type="text" size="5" name="salida2" id="salida2" value="{{$linea->salida2 ? date('H:i',strtotime($linea->salida2)):''}}">
			@endif
			</td>

			@if ($linea->estado == 'Requerido')			
			<td><p class="bg-warning small">Esperando...</p></td>
			@else
			<td><p class="bg-success small">{{$linea->asunto}}</p></td>
			@endif			
			<td>{{$linea->empleado->email}}</td>
			<td><button type="submit" name="requerir" value={{$linea->id}} @if ($linea->estado == 'Requerido'|$linea->estado == 'Firmado') disabled :''@endif>Requerir</button></form></td>
			</tr>
			@endforeach
		</tbody>

	</table>
	


  


@stop