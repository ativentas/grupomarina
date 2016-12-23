<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Grupo Marina</a>
        </div>
        <div style="position: relative; left: 3em;" class="collapse navbar-collapse">

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
                    @if (Auth::user()->isAdmin())
                        <div style=""class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Usuarios <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('auth.listUsers')}}">Gestión Usuarios</a></li>
                                <li><a href="{{route('fileentry')}}">Nominas</a></li>
                                <li><a href="{{ url('/events')}}">Vacac/Bajas</a></li>
                                <li><a href="{{route('cuadrantes')}}">Horarios</a></li>
                            </ul>
                        </div>
                         
                    @endif
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