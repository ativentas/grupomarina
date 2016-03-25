<DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Programa</title>
<style>
	table {
		width:100%;
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
	th {
		border:1px solid #C0C0C0;
		padding:5px;
		background:#F0F0F0;
	}
	td {
		border:1px solid #C0C0C0;
		padding:5px;
	}
</style>
</head>
<body>



<h3>Parte Horario. Fecha: {{$cuadrante->fecha->format('d/m/Y')}} - Centro de Trabajo: {{$cuadrante->centro->nombre}}</h3>


	<table>
		<thead>
			<tr>
			<th>Empleado</th>
			<th>Tipo</th>
			<th style = "">Entrada</th>
			<th style = "">Salida</th>
			<th>Confirmacion</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($lineas as $linea)
			<tr>

			<td>{{$linea->empleado->nombre_completo}}</td>
			<td>{{$linea->tipo}}</td>

			<td class="">
			@if ($linea->entrada == null)			
			@else
			{{date('H:i',strtotime($linea->entrada))}}
			@endif
			@if ($linea->entrada2 == null)
			<br>
			@else
			<br>{{$linea->entrada2 ? date('H:i',strtotime($linea->entrada2)) : ''}}
			@endif
			</td>
			<td>
			@if ($linea->salida == null)
			@else
			{{date('H:i',strtotime($linea->salida))}}
			@endif
			@if ($linea->salida2 == null)
			<br>
			@else
			<br>{{$linea->salida2 ? date('H:i',strtotime($linea->salida2)):''}}
			@endif
			</td>

			@if ($linea->estado == 'Firmado')
			<td>			
	          	<span>Recibido: {{$linea->fechaMensaje}}</span><br>
	          	<span>De: {{$linea->email}}</span><br>
	          	<span>Para: costaservishorarios@gmail.com</span><br>
	          	<span><strong>Asunto: {{$linea->asunto}}</strong></span><br>
	          	<span><code>{{$linea->body}}</code></span>
			        
			</td>
			@else
			<td>{{$linea->asunto}}</td>
			@endif			


			</tr>

			@endforeach
		</tbody>
	</table>


</body>
</html>

