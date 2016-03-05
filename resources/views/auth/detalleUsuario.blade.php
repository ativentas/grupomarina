@extends('templates.default')

@section('content')
	
<h3 style="" class"">Usuario: {{$usuario->username}}</h3>
<hr>
    <div class="col-md-6">
        <form class="form-vertical" role="form" method="post" action="{{route('usuarios.modificar', $usuario->id)}}">
            <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                <label for="email" class="control-label">Correo electrónico</label>
                <input type="text" name="email" class="form-control" id="email" value="{{$usuario->email}}">
                @if ($errors->has('email'))
                	<span class="help-block">{{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('username') ? ' has-error' : ''}}">
                <label for="username" class="control-label">Nombre de usuario</label>
                <input type="text" name="username" class="form-control" id="username" value="{{$usuario->username}}">
                @if ($errors->has('username'))
                    <span class="help-block">{{$errors->first('username')}}</span>
                @endif                  
            </div>            
            <div class="form-group{{$errors->has('nombre') ? ' has-error' : ''}}">
                <label for="username" class="control-label">Nombre Completo</label>
                <input type="text" name="nombre" class="form-control" id="nombre" value="{{$usuario->nombre_completo}}">
                @if ($errors->has('nombre'))
                	<span class="help-block">{{$errors->first('nombre')}}</span>
                @endif	                
            </div>
            
            <div class="form-group">
				<label for="restaurante" class="control-label">Restaurante</label>
				<select class="form-control" id="restaurante" name="restaurante">
					<option{{$usuario->restaurante=='MARINA'?' selected':''}}>MARINA</option>
					<option{{$usuario->restaurante=='CORTES'?' selected':''}}>CORTES</option>
					<option{{$usuario->restaurante=='RACO'?' selected':''}}>RACO</option>
					<option{{$usuario->restaurante=='N/A'?' selected':''}}>N/A</option>
				</select>
			</div>
            <div class="form-group">
                <label for="empresa" class="control-label">Empresa</label>
                <select class="form-control" id="empresa" name="empresa">
                    <option{{$usuario->empresa=='COSTASERVIS'?' selected':''}}>COSTASERVIS</option>
                    <option{{$usuario->empresa=='VILA MOEMA'?' selected':''}}>VILA MOEMA</option>
                    <option{{$usuario->empresa=='N/A'?' selected':''}}>N/A</option>
                </select>
            </div>
            <div class="form-group{{$errors->has('entrada')|$errors->has('salida') ? ' has-error' : ''}}">
                <label for="entrada" class="control-label">Hora Entrada</label>
                <input type="text" name="entrada" id="entrada" size=5 value="{{$usuario->entrada? date('H:i',strtotime($usuario->entrada)) :''}}" placeholder="00:00">
                <label for="salida" class="control-label">Hora Salida</label>
                <input type="text" name="salida" id="salida" size=5 value="{{$usuario->salida? date("H:i",strtotime($usuario->salida)) :''}}" placeholder="00:00">
                @if ($errors->has('entrada')|$errors->has('salida'))
                    <span class="help-block">{{$errors->first('entrada')}} {{$errors->first('salida')}}</span>
                @endif  
            </div>
			@if (Auth::user()->is_root==1)
            <div class="checkbox">
                        <label><input type="checkbox" name="supervisor" id="supervisor" value="yes" {{$usuario->is_supervisor==1?' checked':''}}> Es supervisor de ese Restaurante</label>
            </div>
            @endif
            <select class="form-control" id="empresa" name="empresa">
                    <option{{$usuario->empresa=='COSTASERVIS'?' selected':''}}>COSTASERVIS</option>
                    <option{{$usuario->empresa=='VILA MOEMA'?' selected':''}}>VILA MOEMA</option>
                    <option{{$usuario->empresa=='N/A'?' selected':''}}>N/A</option>
            </select>
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
            <div {{$usuario->turno_partido == 0 ? 'hidden' :''}} id="horariosPartidos" class="form-group{{$errors->has('entrada2')|$errors->has('salida2') ? ' has-error' : ''}}">
                <label for="entrada2" class="control-label">Hora Entrada 2</label>
                <input type="text" size=5 name="entrada2" id="entrada2" value="{{$usuario->entrada2? date('H:i',strtotime($usuario->entrada2)) :''}}" placeholder="00:00">
                <label for="salida2" class="control-label">Hora Salida 2</label>
                <input type="text" size=5 name="salida2" id="salida2" value="{{$usuario->salida2? date('H:i',strtotime($usuario->salida2))  :''}}" placeholder="00:00">
                @if ($errors->has('entrada2')|$errors->has('salida2'))
                    <span class="help-block">{{$errors->first('entrada2')}} {{$errors->first('salida2')}}</span>
                @endif 
            </div>
            
            @if (Auth::user()->is_root==1)
            <div class="checkbox">
			<label><input type="checkbox" name="administrador" id="administrador" value="yes" {{$usuario->is_admin==1?' checked':''}}> Es Administrador</label>
			</div>
            <hr>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-default">Modificar</button>
            </div>
            <input type="hidden" name="_token" value="{{Session::token()}}">
        </form>
    </div>
</div>


@stop