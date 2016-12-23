<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Grupo Marina</a>
            @if (Auth::check())
                @if (Auth::user()->isAdmin())
            <ul class="nav navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="{{route('auth.listUsers')}}">Gestion Usuarios</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="{{route('fileentry')}}">Nominas</a>
                </li>                
                <li class="nav-item">
                <a class="nav-link" href="{{ url('/events')}}">Vacac/Bajas</a>
                </li>                
                <li class="nav-item">
                <a class="nav-link" href="{{route('cuadrantes')}}">Horarios</a>
                </li>
            </ul>
                @endif
            @endif
        </div>

            <ul style="padding-top: 0.5em"class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    
                <div style=""class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    {{ Auth::user()->username }} <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                    @if (Auth::user()->isAdmin())
                    <li><a href="{{url('usuarios/modificar/' . Auth::user()->id)}}">Perfil</a></li>
                    @endif                 
                    <li><a href="{{route('nominasEmpleado')}}">Nominas</a></li>
                    <li><a href="{{route('listadoVacaciones')}}">Vacaciones</a></li>
                    <li><a href="{{route('user.cambioPassword')}}">Cambio Password</a></li>
                    </ul>
                </div>

                    <div style="padding-left: 3em"class="btn-group">
                    <li><button type="button" class="btn btn-default"><a href="{{route('home')}}">Home</a></button></li>
                    </div>
                    <div style="padding-left: 3em"class="btn-group">
                    <li><a href="{{route('auth.signout')}}">Log out</a></li>
                    </div>
                @else
                    
                    <li><a href="{{route('auth.signin')}}">Entrar</a></li>
                @endif
            </ul>
        </div>

    </div>
</nav>