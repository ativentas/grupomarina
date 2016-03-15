
@extends('layout')

@section('content')

<div class="row">
	<div clss="col-lg-12">
		<ol class="breadcrumb">
			<li class="active">Calendario</li>
			<li><a href="{{ url('/events') }}">Eventos</a></li>
			<li><a href="{{ url('/events/create') }}">Nuevo Evento</a></li>

		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div id='calendar'></div>
	</div>
</div>

@endsection

@section('js')
<script src="{{ url('_asset/fullcalendar') }}/fullcalendar.min.js"></script>
<script src="{{ url('_asset/fullcalendar') }}/lang/es.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		
		var base_url = '{{ url('/') }}';

		$('#calendar').fullCalendar({
			weekends: true,
			lang: 'es',
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'basicDay,month,basicWeek',

			},
			defaultView: 'basicWeek',
			slotEventOverlap: false,
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: base_url + '/api',
				error: function() {
					alert("cannot load json");
				}
			}

		});

	});
</script>
@endsection