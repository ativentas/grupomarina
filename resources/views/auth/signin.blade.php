@extends('templates.default')

@section('content')
	<h3>Introduce tus datos</h3>
	<div class="row">
	    <div class="col-lg-4">
	        <form autocomplete="off" class="form-vertical" role="form" method="post" action="{{route('auth.signin')}}">
	            <div class="form-group{{$errors->has('username') ? ' has-error' : ''}}">
	                <label for="username" class="control-label">Usuario</label>
	                <input type="text" autocomplete="off" name="username" class="form-control" id="username" value="{{Request::old('username') ?: ''}}">
	                @if ($errors->has('username'))
	                	<span class="help-block">{{$errors->first('username')}}</span>
	                @endif
	            </div>
	            <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
	                <label for="password" class="control-label">Password</label>
	                <input type="password" autocomplete="off" name="password" class="form-control" id="password">
	                @if ($errors->has('password'))
	                	<span class="help-block">{{$errors->first('password')}}</span>
	                @endif
	            </div>
	            <div class="checkbox">
	                <label>
	                    <input type="checkbox" name="remember"> Remember me
	                </label>
	            </div>
	            <div class="form-group">
	                <button type="submit" class="btn btn-default">Sign in</button>
	            </div>
	            <input type="hidden" name="_token" value="{{Session::token()}}">
	        </form>
	    </div>
	</div>	
@stop

