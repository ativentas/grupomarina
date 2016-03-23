@extends('layout')

@section('content')


<div class="row">
	<div clss="col-lg-12">
		<ol class="breadcrumb">
			<li class="active">Vacaciones</li>
			<li><a data-toggle="collapse" data-target="#solicitud">Solicitar Vacaciones</a></li>
			<!-- <li><a href="{{ url('events/create') }}">Solicitar Vacaciones</a></li> -->
		</ol>
	</div>
</div>
@include('message')
<div id="solicitud" class="row collapse">
<div class="col-lg-6">
	
		<form action="{{ url('events') }}" method="POST" autocomplete="off">
			{{ csrf_field() }}

			<div class="form-group">
				<input type="hidden" name="empleado" value="{{ Auth::user()->id }}">
			</div>


			<div class="form-group">
				<input type="hidden" class="form-control" id="title" name="title" value="Vacaciones">	
				</select>
			</div>
			<div class="form-group @if($errors->has('time')) has-error @endif">
				<label for="time">Fechas</label>
				<div class="input-group">
					<input type="text" class="form-control" name="time" placeholder="Select your time" value="{{ old('time') }}">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
				@if ($errors->has('time'))
					<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign"></span> 
					{{ $errors->first('time') }}
					</p>
				@endif
			</div>
			<button type="submit" class="btn btn-primary" name="solicitudEmpleado" value="1">Solicitar</button>
		</form>		
	</div>

</div>
<div class="row">
	<div class="col-lg-12">
		@if($events->count() > 0)
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th></th>
					<th>Comienzo</th>
					<th>Fin</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $i = 1;?>
			@foreach($events as $event)
				<tr>
					<th scope="row">{{ $i++ }}</th>
					<td>{{ $event->title }}</td>
					<td>{{ date("j M Y", strtotime($event->start_time)) }}</td>
					<td>{{ date("j M Y", strtotime($event->finalDay)) }}</td>
					<td>{{ $event->estado }}</td>
					<td>
						@if ($event->estado == 'Pendiente')
						<form action="{{ url('events/' . $event->id) }}" style="display:inline" method="POST">
							<input type="hidden" name="_method" value="DELETE" />
							{{ csrf_field() }}
							<button class="btn btn-danger btn-xs" type="submit" name="solicitudEmpleado" value="1"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
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

@section('js')
<script src="{{ url('_asset/js') }}/daterangepicker.js"></script>
<script type="text/javascript">
$(function () {
	$('input[name="time"]').daterangepicker({
		"minDate": moment('<?php echo date('Y-m-d G')?>'),
		"autoApply": true,
		"locale": {
			"format": "DD/MM/YYYY",
			"separator": " - ",
		}
	});
});
</script>
@endsection
