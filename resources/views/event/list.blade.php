@extends('layout')

@section('content')

<div class="row">
	<div clss="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="{{ url('events/calendario') }}">Calendario</a></li>
			<li class="active">Eventos</li>
			<li><a href="{{ url('events/create') }}">Nuevo Evento</a></li>
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
					<th>Evento</th>
					<th>Comienzo</th>
					<th>Fin</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $i = 1;?>
			@foreach($events as $event)
				<tr>
					<th scope="row">{{ $i++ }}</th>
					<td><a href="{{ url('events/' . $event->id) }}">{{ $event->title }}</a></td>
					<td>{{ date("jS M Y", strtotime($event->start_time)) }}</td>
					<td>{{ date("jS M Y", strtotime($event->finalDay)) }}</td>
					<td>
						<a class="btn btn-primary btn-xs" href="{{ url('events/' . $event->id . '/edit')}}">
							<span class="glyphicon glyphicon-edit"></span> Edit</a> 
						<form action="{{ url('events/' . $event->id) }}" style="display:inline" method="POST">
							<input type="hidden" name="_method" value="DELETE" />
							{{ csrf_field() }}
							<button class="btn btn-danger btn-xs" type="submit"><span class="glyphicon glyphicon-trash"></span> Delete</button>
						</form>
						
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
