@extends('templates.default')

@section('content')
	
<h3 style="" class"">Usuario: {{$usuario->username}}</h3>
<hr>
    <div class="col-lg-6">
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
            
            <div class="form-group">
				<label for="restaurante" class="control-label">Restaurante</label>
				<select class="form-control" id="restaurante" name="restaurante">
					<option{{$usuario->restaurante=='MARINA'?' selected':''}}>MARINA</option>
					<option{{$usuario->restaurante=='CORTES'?' selected':''}}>CORTES</option>
					<option{{$usuario->restaurante=='RACO'?' selected':''}}>RACO</option>
					<option{{$usuario->restaurante=='N/A'?' selected':''}}>N/A</option>
				</select>
			</div>
			@if (Auth::user()->is_root==1)
            <div class="checkbox">
                        <label><input type="checkbox" name="supervisor" id="supervisor" value="yes" {{$usuario->is_supervisor==1?' checked':''}}> Es supervisor de ese Restaurante</label>
            </div>
            @endif
            <hr>
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