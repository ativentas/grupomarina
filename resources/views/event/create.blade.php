@extends('layout')

@section('content')

<div class="row">
	<div clss="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="{{ url('events/calendario') }}">Calendario</a></li>
			<li><a href="{{ url('/events') }}">Vacac/Bajas</a></li>
			<li class="active">Nuevo Vacac/Bajas</li>
		</ol>
	</div>
</div>

@include('message')

<div class="row">
	<div class="col-lg-6">
		
		<form action="{{ url('events') }}" method="POST" autocomplete="off">
			{{ csrf_field() }}

			<div class="form-group @if($errors->has('empleado')) has-error has-feedback @endif">
				<select class="form-control" id="empleado" name="empleado">
					<option value="">Elige un Empleado</option>
					@foreach($empleados as $empleado)
					<option value="{{$empleado->id}}" @if(old('empleado')==$empleado->id) selected="selected" @endif>{{$empleado->username}}</option>
					@endforeach
				</select>
				@if ($errors->has('empleado'))
					<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign"></span> 
					{{ $errors->first('empleado') }}
					</p>
				@endif                
            </div>


			<div class="form-group @if($errors->has('title')) has-error has-feedback @endif">
				<select class="form-control" id="title" name="title">
					<option value="">Elige...</option>
					<option value="Vacaciones" @if(old('title')=='Vacaciones') selected="selected" @endif>Vacaciones</option>
					<option value="Baja" @if(old('title')=='Baja') selected="selected" @endif>Baja</option>
					<option value="Falta" @if(old('title')=='Falta') selected="selected" @endif>Falta</option>
				</select>

				@if ($errors->has('title'))
					<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign"></span> 
					{{ $errors->first('title') }}
					</p>
				@endif
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
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>		
	</div>
</div>
@endsection

@section('js')
<script src="{{ url('_asset/js') }}/daterangepicker.js"></script>
<script type="text/javascript">
$(function () {
	$('input[name="time"]').daterangepicker({
		// "minDate": moment('<?php echo date('Y-m-d G')?>'),
		"autoApply": true,
		"locale": {
			"format": "DD/MM/YYYY",
			"separator": " - ",
		}
	});
});
</script>
@endsection