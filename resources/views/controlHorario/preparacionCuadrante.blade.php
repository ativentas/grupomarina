@extends('templates.default')

@section('content')
<form>
	<table class="table table-bordered">
		<thead>
			<tr>
			<th>Empleado</th>
			<th>Tipo</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($empleados as $empleado)
			<tr>
			<td>{{$empleado->username}}</td>
			<td>Turno</td>
			<td>Libre</td>
			<td></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<button type="submit" class="btn btn-default">Submit</button>
</form>













@stop