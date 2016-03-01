@extends('templates.default')

@section('content')
	
<div style="display:inline" align="center">
        <button type="button" style="display:inline" class="btn btn-info" data-toggle="collapse" data-target="#nuevo">Alta Nuevo Usuario</button>
        <h3 style="" class"">Mantenimiento Usuarios</h3>
</div>
    <hr>
    
	
<div id="nuevo" class="row collapse{{$errors->count() ? ' in' : ''}}">
    <div class="col-lg-6">
        <form autocomplete="off" class="form-vertical" role="form" method="post" action="{{route('auth.signup')}}">
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
            
            <div class="form-group{{$errors->has('restaurante') ? ' has-error' : ''}}">
                <!-- <label for="restaurante" class="control-label">Elegir Restaurante</label> -->
                <select class="form-control" id="restaurante" name="restaurante">
                    <option value="">Elige un Restaurante</option>
                    <option>MARINA</option>
                    <option>CORTES</option>
                    <option>RACO</option>
                    <option>N/A</option>
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
                <select class="form-control" id="empresa" name="empresa">
                    <option value="">Elige una Empresa</option>
                    <option>COSTASERVIS</option>
                    <option>VILA MOEMA</option>
                    <option>N/A</option>
                </select>
                @if ($errors->has('empresa'))
                    <span class="help-block">{{$errors->first('empresa')}}</span>
                @endif 
            </div>
			<hr>
            @if(Auth::user()->is_root==1) 
            <div class="checkbox">
	    		<label><input type="checkbox" name="administrador" id="administrador" value="1"> Es administrador</label>
			</div>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-default">Registrar</button>
            </div>
            
            <input type="hidden" name="_token" value="{{Session::token()}}">
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        
        @if (!$usuariosAdministradores)
        	<p>No hay ningun administrador todavía</p>
        @else
        	<h3>Administradores</h3>
        	<table class="table table-striped">
			    <thead>
			    	<tr>  		
    					<th>Nombre</td>
                           					
			    		<th>Estado</th>
			        	<th></th>
			    	</tr>
			    </thead>
			    <tbody>
        	@foreach ($usuariosAdministradores as $usuario)
					<tr>						
                        <td>{{$usuario->username}}</td>
    					
    					@if ($usuario->active=='1')
    					<td>
						<label for="" style="color:green">ACTIVO</label>
    					</td>
                        <td>
                            @if(Auth::user()->is_root==1 && !$usuario->is_root==1)
                            <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                 {{ csrf_field() }}
                                <button class="btn-warning" name="estado" value="0">Suspender</button>
                            </form>
                            @endif
                        </td>
                        @elseif ($usuario->active=='0')
                        <td>
                        <label for="" style="color:red">SUSPENDIDO</label>
                        </td>
                        <td>
                            @if(Auth::user()->is_root==1 && $usuario->is_root==0)
                            <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                 {{ csrf_field() }}
                                <button class="btn-success" name="estado" value="1">Reactivar</button>
                            </form>
                            @endif
                        </td>
                        @endif
                        
                        @if (Auth::user()->is_root==1 && $usuario->is_root==0)	    					
   					
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
                        @elseif (Auth::user()->is_root ==0 && Auth::user()->id == $usuario->id)
					    <td>
                            
                            <form action="{{route('usuarios.modificar', $usuario->id)}}" method="GET">
                                 {{ csrf_field() }}
                                <button class="btn-info">Modificar</button>
                            </form>                            
                        </td>
                        @else
                        <td>
                                                    
                        </td>
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
            
            @if (!$usuariosNormales)
            	<p>No hay ningun usuario todavía</p>
            @else
            	<h3>Usuarios</h3>
            	<table class="table table-striped">
    			    <thead>
    			    	<tr>  		
                            <th>Nombre</td>
        					<th>Empresa</td>
                            <th>Restaurante</th>   					
    			    		<th>Estado</th>
    			        	<th></th>
    			    	</tr>
    			    </thead>
    			    <tbody>
            	@foreach ($usuariosNormales as $usuario)
    					<tr>						
                            <td>{{$usuario->username}}</td>
                            <td>{{$usuario->empresa}}</td>
        					<td>{{$usuario->restaurante}}</td>
                            @if ($usuario->active=='1')
                            <td>
                            <label for="" style="color:green">ACTIVO</label>
                            </td>
                            @if (Auth::user()->is_root==1 || Auth::user()->is_admin==1)                          
                            <td>
                                
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                     {{ csrf_field() }}
                                    <button class="btn-warning" name="estado" value="0">Suspender</button>
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
                            @else
                            <td>
                            <label for="" style="color:red">SUSPENDIDO</label>
                            </td>
                            @if (Auth::user()->is_root==1 || Auth::user()->is_admin==1)
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