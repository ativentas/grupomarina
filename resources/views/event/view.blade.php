@extends('layout')

@section('content')

<div class="row">
	<div clss="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="{{ url('events/calendario') }}">Calendario</a></li>
			<li><a href="{{ url('/events') }}">Eventos</a></li>
			<li class="active">{{ $event->title }}</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<h2>{{ $event->title }} <small>{{ $event->name }}</small></h2>
		<hr>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		
		<p>Fechas: <br>
		{{ date("jS M Y", strtotime($event->start_time)) . ' hasta ' . date("jS M Y", strtotime($event->finalDay)) }}
		</p>
		
		<p>Duración: <br>
		{{ $duration }}
		</p>
		
		<p>
			<form action="{{ url('events/' . $event->id) }}" style="display:inline;" method="POST">
				<input type="hidden" name="_method" value="DELETE" />
				{{ csrf_field() }}
				<button class="btn btn-danger" type="submit"><span class="glyphicon glyphicon-trash"></span> Delete</button>
			</form>
			<a class="btn btn-primary" href="{{ url('events/' . $event->id . '/edit')}}">
				<span class="glyphicon glyphicon-edit"></span> Edit</a> 
			
		</p>
		
	</div>
</div>
@endsection

@section('js')
<script src="{{ url('_asset/js') }}/daterangepicker.js"></script>
<script type="text/javascript">
$(function () {
	$('input[name="time"]').daterangepicker({
		"timePicker": true,
		"timePicker24Hour": true,
		"timePickerIncrement": 15,
		"autoApply": true,
		"locale": {
			"format": "DD/MM/YYYY HH:mm:ss",
			"separator": " - ",
		}
	});
});
</script>
@endsection