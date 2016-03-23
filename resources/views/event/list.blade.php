@extends('layout')

@section('content')

<div class="row">
	<div clss="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="{{ url('events/calendario') }}">Calendario</a></li>
			<li class="active">Vacac/Bajas</li>
			<li><a href="{{ url('events/create') }}">Nuevo Vacac/Bajas</a></li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		@if($events->count() > 0)
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Tipo</th>
					<th>Empleado</th>
					<th>Comienzo</th>
					<th>Fin</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $i = 1;?>
			@foreach($events as $event)
				<tr>
					<th scope="row">{{ $i++ }}</th>
					<td>{{ $event->title }}</td>
					<!-- <td><a href="{{ url('events/' . $event->id) }}">{{ $event->title }}</a></td> -->
					<td><a href="{{ url('/usuarios/modificar/' . $event->empleado_id) }}">{{ $event->name }}</a></td>
					<td>{{ date("j M Y", strtotime($event->start_time)) }}</td>
					<td>{{ date("j M Y", strtotime($event->finalDay)) }}</td>
					<td>{{ $event->estado }}</td>
					<td>
						<!-- <a class="btn btn-primary btn-xs" href="{{ url('events/' . $event->id . '/edit')}}">
							<span class="glyphicon glyphicon-edit"></span> Edit</a>  -->
						@if($event->estado=='Pendiente')
						<form action="{{ route('confirmarVacaciones',$event->id) }}" style="display:inline" method="POST">
							{{ csrf_field() }}
							<input type="hidden" name="accion" value="REQUERIR" />
							<button class="btn btn-success btn-xs" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Confirmar</button>
						</form>						
						<form action="{{ url('events/' . $event->id) }}" style="display:inline" method="POST">
							<input type="hidden" name="_method" value="DELETE" />
							{{ csrf_field() }}
							<button class="btn btn-danger btn-xs" type="submit"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
						</form>

						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		@else
			<h2>No hay ningún evento</h2>
		@endif
	</div>
</div>
@endsection
