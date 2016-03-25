@extends('templates.default')

@section('content')
	
<div style="display:inline" align="center">
        
       <form style="display:inline" role="form" action="{{route('usuarios.createFiltrado', 'centro')}}" method="get">
        <div class="col-md-4 form-group">
            <select class="form-control" id="centro" name="centro">
                <option value="">TODOS</option>
                @foreach ($centros as $centro)
                <option value="{{$centro->id}}">{{$centro->nombre}}</option>
                @endforeach
            </select>                  
        </div>
        <button type="submit" class="btn">Filtrar</button>
        </form>

        <button type="button" style="display:inline" class="btn btn-info" data-toggle="collapse" data-target="#nuevo">Alta Nuevo Usuario</button>
        <!-- <h3 style="" class"">Mantenimiento Usuarios</h3> -->



</div>
    <hr>
    
@if ($errors->count()>0)
    <div class="alert alert-danger">Error al dar de alta. Revisa abajo los datos erroneos y vuelve a intentarlo</div>
@endif	
<div class="container">
<div id="nuevo" class="row collapse{{$errors->count() ? ' in' : ''}}">
    
    <div class="row col-md-5">
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
                    @foreach ($restaurantes as $restaurante)
                    <option value={{$restaurante->id}}>{{$restaurante->nombre}}</option>
                    @endforeach
                    <option {{Request::old('restaurante')==0?' selected':''}} value="">N/A</option>
                </select>
                @if ($errors->has('restaurante'))
                    <span class="help-block">{{$errors->first('restaurante')}}</span>
                @endif  
            </div>            

            <div class="checkbox">
                <label><input type="checkbox" name="supervisor" id="supervisor" value="1"> Es supervisor de ese Restaurante</label>
            </div>
    </div>
    <div class="row col-md-5 col-md-offset-1">
            <div class="form-group{{$errors->has('empresa') ? ' has-error' : ''}}">
                <!-- <label for="empresa" class="control-label">Elegir Empresa</label> -->
                <label for="empresa"> &nbsp;</label>
                <select class="form-control" id="empresa" name="empresa">
                    <option value="">¿En qué empresa está de alta?</option>
                    @foreach ($empresas as $empresa)
                    <option value={{$empresa->id}}>{{$empresa->nombre}}</option>
                    @endforeach
                    <option {{Request::old('empresa')==0?' selected':''}} value="">N/A</option>
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
</div>
</div>


    <div class="row">
        <div class="col-lg-8">
           
            @if (!$usuariosNormales)
            	<p>No hay ningun usuario todavía</p>
            @else
<!--             	<h3>Usuarios</h3> -->
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
                            <td>{{$usuario->empresa['nombre']}}</td>
        					<td>{{$usuario->restaurante['nombre']}}</td>
                            @if ($usuario->active=='1')
                            <td>
                            <label for="" style="color:green">ACTIVO</label>
                            </td>
                            @if (Auth::user()->isRoot() || Auth::user()->isAdmin())                          
                            <td>
                                @if(!$usuario->isAdmin() && !$usuario->isRoot())
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                     {{ csrf_field() }}
                                    <button class="btn-warning" name="estado" value="0">Suspender</button>
                                </form>
                                @endif
                            </td>                       
                            <td>
                                @if(!$usuario->isAdmin() && !$usuario->isRoot())
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                                     {{ csrf_field() }}
                                    <button class="btn-danger" name="password" value="reset">Reset Pwd</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                @if(!$usuario->isAdmin() && !$usuario->isRoot())
                                <form action="{{route('usuarios.modificar', $usuario->id)}}" method="GET">
                                     {{ csrf_field() }}
                                    <button class="btn-info">Modificar</button>
                                </form>
                                @endif
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