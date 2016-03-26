@extends('layout')

@section('content')

<div class="row">
    <div clss="col-lg-12">
        <ol class="breadcrumb">
            <!-- <li><a href="{{ url('events/calendario') }}">Calendario</a></li> -->
            <li class="active">Listado</li>
            <li><a href="{{ url('nuevoUsuario') }}">Nuevo Usuario</a></li>
        </ol>
    </div>
</div>
	
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

   <!--  <button type="button" style="display:inline" class="btn btn-info" data-toggle="collapse" data-target="#nuevo">Alta Nuevo Usuario</button> -->
    <!-- <h3 style="" class"">Mantenimiento Usuarios</h3> -->
</div>

    <!-- <hr> -->
    
@if ($errors->count()>0)
<div class="alert alert-danger">Error al dar de alta. Revisa abajo los datos erroneos y vuelve a intentarlo</div>
@endif	
<div class="row">

       
        @if (!$usuariosNormales)
        <p>No hay ningun usuario todavía</p>
        @else
        <!--    <h3>Usuarios</h3> -->
    	<table class="table table-striped">
		    <thead>
		    	<tr>  		
                    <th>Nombre</th>
					<th>Empresa</th>
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
                            <button class="btn btn-warning btn-xs" type="submit" name="estado" value="0"><span class="glyphicon glyphicon-remove-sign"></span> Suspender</button>
               <!--              <button class="btn-warning" name="estado" value="0">Suspender</button> -->
                        </form>
                        @endif
                    </td>                       
                    <td>
                        @if(!$usuario->isAdmin() && !$usuario->isRoot())
                        <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                             {{ csrf_field() }}
                            <button class="btn btn-danger btn-xs" type="submit" name="password" value="reset"><span class="glyphicon glyphicon-transfer"></span> Reset Pwd</button>
                            <!-- <button class="btn-danger" name="password" value="reset">Reset Pwd</button> -->
                        </form>
                        @endif
                    </td>
                    <td>
                        @if(!$usuario->isAdmin() && !$usuario->isRoot())
                        <form action="{{route('usuarios.modificar', $usuario->id)}}" method="GET">
                             {{ csrf_field() }}
                            <button class="btn btn-info btn-xs" type="submit"><span class="glyphicon glyphicon-pencil"></span> Ver/Editar</button>
                            <!-- <button class="btn-info">Modificar</button> -->
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
                            <button class="btn btn-success btn-xs" type="submit" name="estado" value="1"><span class="glyphicon glyphicon-ok-sign"></span> Reactivar</button>
                            <!-- <button class="btn-success" name="estado" value="1">Reactivar</button> -->
                        </form>
                    </td>
                    <td>
                        <form action="{{route('usuarios.modificar', $usuario->id)}}" method="POST">
                             {{ csrf_field() }}
                            <button class="btn btn-danger btn-xs" type="submit" name="password" value="reset"><span class="glyphicon glyphicon-transfer"></span> Reset Pwd</button>
                            <!-- <button class="btn-danger" name="password" value="reset">Reset Pwd</button> -->
                        </form>
                    </td>
                    <td>
                        <form action="{{route('usuarios.modificar', $usuario->id)}}" method="GET">
                             {{ csrf_field() }}
                             <button class="btn btn-info btn-xs" type="submit"><span class="glyphicon glyphicon-pencil"></span> Ver/Editar</button>
                            <!-- <button class="btn-info">Modificar</button> -->
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
@stop