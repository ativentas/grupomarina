@extends('templates.default')

@section('content')
	
<div style="display:inline" align="center">
        <button type="button" style="display:inline" class="btn btn-info" data-toggle="collapse" data-target="#nuevo">Alta Nuevo Usuario</button>
        <h3 style="" class"">Mantenimiento Usuarios</h3>
</div>
    <hr>
    
	
<div id="nuevo" class="row collapse{{$errors->has('email')||$errors->has('username')||$errors->has('password')||$errors->has('password_confirmation') ? ' in' : ''}}">
    <div class="col-lg-6">
        <form class="form-vertical" role="form" method="post" action="{{route('auth.signup')}}">
            <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                <label for="email" class="control-label">Correo electrónico</label>
                <input type="text" name="email" class="form-control" id="email" value="{{Request::old('email') ?: ''}}">
                @if ($errors->has('email'))
                	<span class="help-block">{{$errors->first('email')}}</span>
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
            
            <div class="form-group">
				<!-- <label for="restaurante" class="control-label">Elegir Restaurante</label> -->
				<select class="form-control" id="restaurante" name="restaurante">
					<option>Elige un Restaurante</option>
					<option>MARINA</option>
					<option>CORTES</option>
					<option>RACO</option>
					<option>N/A</option>
				</select>
			</div>
			<div class="checkbox">
	    				<label><input type="checkbox" name="supervisor" id="supervisor" value="1"> Es supervisor de ese Restaurante</label>
			</div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Registrar</button>
            </div>
            <input type="hidden" name="_token" value="{{Session::token()}}">
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        
        @if (!$usuarios->where('is_admin',1)->count())
        	<p>No hay ningun administrador todavía</p>
        @else
        	<h3>Administradores</h3>
        	<table class="table table-striped">
			    <thead>
			    	<tr>  		
    					<th>Nombre</td>
                        <th>Restaurante</th>   					
			    		<th>Estado</th>
			        	<th></th>
			    	</tr>
			    </thead>
			    <tbody>
        	@foreach ($usuarios->where('is_admin',1) as $usuario)
					<tr>						
                        <td>{{$usuario->username}}</td>
    					<td>{{$usuario->restaurante}}</td>
    					@if ($usuario->active=='1')
    					<td>
						<label for="" style="color:green">ACTIVO</label>
    					</td>
    					@if (Auth::user()->is_root==1)	    					
    					<td>
    						@if(!$usuario->is_root==1)
                            <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
					             {{ csrf_field() }}
					            <button class="btn-warning" name="estado" value="0">Suspender</button>
					        </form>
                            @endif
					    </td>   					
    					<td>
    						@if(!$usuario->is_root==1)
                            <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
					             {{ csrf_field() }}
					            <button class="btn-danger" name="password" value="reset">Reset Pwd</button>
					        </form>
                            @endif
					    </td>
    					<td>
    						<form action="{{route('usuarios.modificar', $usuario->id)}}" method="GET">
					             {{ csrf_field() }}
					            <button class="btn-info">Modificar</button>
					        </form>
					    </td>
					    @endif
    					@else
						<td>
						<label for="" style="color:red">SUSPENDIDO</label>
    					</td>
						@if (Auth::user()->is_root==1)
						<td>
    						<form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
					             {{ csrf_field() }}
					            <button class="btn-success" name="estado" value="1">Reactivar</button>
					        </form>
					    </td>
    					<td>
    						<form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
					             {{ csrf_field() }}
					            <button class="btn-danger" name="password" value="reset">Reset Pwd</button>
					        </form>
					    </td>
    					<td>
    						<form action="{{route('usuarios.modificar', $usuario->id)}}" method="GET">
					             {{ csrf_field() }}
					            <button class="btn-info">Modificar</button>
					        </form>
					    </td>
						@endif
    					@endif    					       					
					</tr>
        	@endforeach
        		</tbody>
				</table>
        @endif
    </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            
            @if (!$usuarios->where('is_admin',0)->count())
            	<p>No hay ningun usuario todavía</p>
            @else
            	<h3>Usuarios</h3>
            	<table class="table table-striped">
    			    <thead>
    			    	<tr>  		
        					<th>Nombre</td>
                            <th>Restaurante</th>   					
    			    		<th>Estado</th>
    			        	<th></th>
    			    	</tr>
    			    </thead>
    			    <tbody>
            	@foreach ($usuarios->where('is_admin',0) as $usuario)
    					<tr>						
                            <td>{{$usuario->username}}</td>
        					<td>{{$usuario->restaurante}}</td>
                            @if ($usuario->active=='1')
                            <td>
                            <label for="" style="color:green">ACTIVO</label>
                            </td>
                            @if (Auth::user()->is_root==1)                          
                            <td>
                                @if(!$usuario->is_root==1)
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                     {{ csrf_field() }}
                                    <button class="btn-warning" name="estado" value="0">Suspender</button>
                                </form>
                                @endif
                            </td>                       
                            <td>
                                @if(!$usuario->is_root==1)
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                     {{ csrf_field() }}
                                    <button class="btn-danger" name="password" value="reset">Reset Pwd</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="GET">
                                     {{ csrf_field() }}
                                    <button class="btn-info">Modificar</button>
                                </form>
                            </td>
                            @endif
                            @else
                            <td>
                            <label for="" style="color:red">SUSPENDIDO</label>
                            </td>
                            @if (Auth::user()->is_root==1)
                            <td>
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                     {{ csrf_field() }}
                                    <button class="btn-success" name="estado" value="1">Reactivar</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                     {{ csrf_field() }}
                                    <button class="btn-danger" name="password" value="reset">Reset Pwd</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="GET">
                                     {{ csrf_field() }}
                                    <button class="btn-info">Modificar</button>
                                </form>
                            </td>
                            @endif
                            @endif          
 					
     					 </tr>
            	@endforeach
            		</tbody>
    				</table>
            @endif
        </div>
    </div>
@stop