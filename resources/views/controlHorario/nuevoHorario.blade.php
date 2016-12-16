@extends('layout')

@section('content')

<div class="row">
    <div clss="col-lg-12">
        <ol class="breadcrumb">
            <!-- <li><a href="{{ url('events/calendario') }}">Calendario</a></li> -->

            <li><a href="{{ url('cuadrantes') }}">Listado</a></li>
            <li class="active">Nuevo Horario</li>
        </ol>
    </div>
</div>

<h3>Crear nuevo o consultar</h3>

<div class="col-sm-4 row">
<form role="form" action="{{route('cuadrante.generar')}}" method="post">
  {{ csrf_field() }}
  <div class="form-group{{$errors->has('fecha') ? ' has-error' : ''}}">
    <label for="fecha">Fecha</label>
    <input type="date" name="fecha" class="form-control" id="fecha" value={{date('d-m-Y')}}>
		@if ($errors->has('fecha'))
			<span class="help-block">{{$errors->first('fecha')}}</span>
		@endif
  </div>
  
	<div class="form-group{{$errors->has('centro') ? ' has-error' : ''}}">
	    <!-- <label for="empresa" class="control-label">Elegir Empresa</label> -->
	    <select class="form-control" id="centro" name="centro">
	        <option value="">Elige Empresa/Restaurante</option>
	        @foreach ($centros as $centro)
          <option value={{$centro->id}}>{{$centro->nombre}}</option>
          @endforeach

	    </select>
		@if ($errors->has('centro'))
			<span class="help-block">{{$errors->first('centro')}}</span>
		@endif	
	</div>

  <button type="submit" class="btn btn-default">Generar</button>
</form>
</div>
@stop