@extends('templates.default')

@section('content')
	
<div class="col-md-5">
    <form class="form-vertical" role="form" method="post" action="{{route('user.cambioPassword')}}">

        <div class="form-group">
            <label for="username" class="control-label"><h3>{{Auth::user()->username}} | Cambio de Password</h3></label>                
        <hr>
        </div>
        <div class="form-group{{$errors->has('old_password') ? ' has-error' : ''}}">
            <label for="old_password" class="control-label">Contraseña Actual</label>
            <input type="password" name="old_password" class="form-control" id="old_password">
            @if ($errors->has('old_password'))
                <span class="help-block">{{$errors->first('old_password')}}</span>
            @endif                  
        </div>        
        <div class="form-group{{$errors->has('new_password') ? ' has-error' : ''}}">
            <label for="password" class="control-label">Nueva Contraseña</label>
            <input type="password" name="new_password" class="form-control" id="new_password">
            @if ($errors->has('new_password'))
            	<span class="help-block">{{$errors->first('new_password')}}</span>
            @endif	                
        </div>
        <div class="form-group{{$errors->has('new_password_confirmation') ? ' has-error' : ''}}">
            <label for="new_password_confirmation" class="control-label">Repite Nueva Contraseña</label>
            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
            @if ($errors->has('new_password_confirmation'))
            	<span class="help-block">{{$errors->first('new_password_confirmation')}}</span>
            @endif	                
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-default">Cambiar</button>
        </div>
        <input type="hidden" name="_token" value="{{Session::token()}}">
    </form>
</div>



@stop