@extends('layout')

@section('content')

<div class="row">
    <div clss="col-lg-12">
        <ol class="breadcrumb">
            <!-- <li><a href="{{ url('events/calendario') }}">Calendario</a></li> -->

            <li><a href="{{ url('listUsers') }}">Listado</a></li>
            <li class="active">Nuevo Usuario</li>
        </ol>
    </div>
</div>
<!-- <div id="nuevo" class="row collapse{{$errors->count() ? ' in' : ''}}"> -->
    
    <div class="row col-md-5">
        <form autocomplete="off" class="form-vertical" role="form" method="post" action="{{route('nuevoUsuario')}}">
            <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                <label for="email" class="control-label">Correo electrónico</label>
                <input type="text" autocomplete="off" name="email" class="form-control" id="email" value="{{Request::old('email') ?: ''}}">
                @if ($errors->has('email'))
                    <span class="help-block">{{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('nombre') ? ' has-error' : ''}}">
                <label for="nombre" class="control-label">Nombre Completo</label>
                <input type="text" autocomplete="off" name="nombre" class="form-control" id="nombre" value="{{Request::old('nombre') ?: ''}}">
                @if ($errors->has('nombre'))
                	<span class="help-block">{{$errors->first('nombre')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('username') ? ' has-error' : ''}}">
                <label for="username" class="control-label">Nombre de usuario</label>
                <input type="text" name="username" class="form-control" id="username" value="{{Request::old('username') ?: ''}}">
                @if ($errors->has('username'))
                	<span class="help-block">{{$errors->first('username')}}</span>
                @endif	                
            </div>
            <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                <label for="password" class="control-label">Contraseña</label>
                <input type="password" name="password" class="form-control" id="password">
                @if ($errors->has('password'))
                	<span class="help-block">{{$errors->first('password')}}</span>
                @endif	                
            </div>
            <div class="form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}">
                <label for="password_confirmation" class="control-label">Repite Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                @if ($errors->has('password_confirmation'))
                	<span class="help-block">{{$errors->first('password_confirmation')}}</span>
                @endif	                
            </div>
            

    </div>
    <div class="row col-md-5 col-md-offset-1">
            
            <div class="form-group{{$errors->has('restaurante') ? ' has-error' : ''}}">
                <label for="restaurante" class="control-label"></label>
                <select class="form-control" id="restaurante" name="restaurante">
                    <option {{Request::old('restaurante')==''?' selected':''}} value="">Elige un Restaurante</option>
                    @foreach ($restaurantes as $restaurante)
                    <option {{Request::old('restaurante')==$restaurante->id ?' selected':''}} value={{$restaurante->id}}>{{$restaurante->nombre}}</option>
                    @endforeach
                    <option value="">N/A</option>
                </select>
                @if ($errors->has('restaurante'))
                    <span class="help-block">{{$errors->first('restaurante')}}</span>
                @endif  
            </div>            

            <div class="checkbox">
                <label><input type="checkbox" name="supervisor" id="supervisor" value="1"> Es supervisor de ese Restaurante</label>
            </div>



            <div class="form-group{{$errors->has('empresa') ? ' has-error' : ''}}">
                <!-- <label for="empresa" class="control-label">Elegir Empresa</label> -->
                <label for="empresa"> &nbsp;</label>
                <select class="form-control" id="empresa" name="empresa">
                    <option {{Request::old('empresa')==''?' selected':''}} value="">¿En qué empresa está de alta?</option>
                    @foreach ($empresas as $empresa)
                    <option {{Request::old('empresa')==$empresa->id ?' selected':''}} value={{$empresa->id}}>{{$empresa->nombre}}</option>
                    @endforeach
                    <option  value="">N/A</option>
                </select>
                @if ($errors->has('empresa'))
                    <span class="help-block">{{$errors->first('empresa')}}</span>
                @endif 
            </div>
            <div class="form-group{{$errors->has('entrada')|$errors->has('salida') ? ' has-error' : ''}}">
                <label for="entrada" class="control-label">Hora Entrada</label>
                <input type="text" size=5 name="entrada" id="entrada" value="{{Request::old('entrada') ?: NULL}}" placeholder="00:00">
                <label for="salida" class="control-label">Hora Salida</label>
                <input type="text" size=5 name="salida" id="salida" value="{{Request::old('salida') ?: NULL}}" placeholder="00:00">
                @if ($errors->has('entrada')|$errors->has('salida'))
                    <span class="help-block">{{$errors->first('entrada')}} {{$errors->first('salida')}}</span>
                @endif 
            </div>
         
            <div class="checkbox">
                <label><input type="checkbox" name="turnoPartido" id="turnoPartido" value="1"> <strong>¿Turno Partido?</strong></label>
            </div>
            <script>
            $("#turnoPartido").change(function() {
                if(this.checked) {
                    $("#horariosPartidos").show();
                }else {
                    $("#horariosPartidos").hide();
                }
            });
            </script>
            
            <br>
            <div hidden id="horariosPartidos" class="form-group{{$errors->has('entrada2')|$errors->has('salida2') ? ' has-error' : ''}}">
                <label for="entrada2" class="control-label">Hora Entrada 2</label>
                <input type="text" size=5 name="entrada2" id="entrada2" value="{{Request::old('entrada2') ?: ''}}" placeholder="00:00">
                <label for="salida2" class="control-label">Hora Salida 2</label>
                <input type="text" size=5 name="salida2" id="salida2" value="{{Request::old('salida2') ?: ''}}" placeholder="00:00">
                @if ($errors->has('entrada2')|$errors->has('salida2'))
                    <span class="help-block">{{$errors->first('entrada2')}} {{$errors->first('salida2')}}</span>
                @endif 
            </div>

			
            @if(Auth::user()->is_root==1) 
            <div class="checkbox">
	    		<label><input type="checkbox" name="administrador" id="administrador" value="1"> Es administrador</label>
			</div>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-default">Registrar</button>
            </div>
            <br><br>
            <input type="hidden" name="_token" value="{{Session::token()}}">
        </form>


    </div>
<!-- </div> -->
@stop