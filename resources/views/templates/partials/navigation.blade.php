<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Grupo Marina</a>
        </div>
        <div class="collapse navbar-collapse">
            @if (Auth::check())
                <ul class="nav navbar-nav">
                    <!-- <li><a href="{{route('pedidos.abiertos')}}">Pedidos Abiertos</a></li>
                    <li><a href="{{route('pedidos.completos')}}">Ultimos</a></li> -->
                    @if(!Auth::user()->isAdmin())
                    <li><a href="{{route('inventarios.pendientes')}}">Inventario</a></li>
                    <li><a href="{{route('inventarios.completos')}}">Ultimos</a></li>
                    <li><a href="{{route('nominasEmpleado')}}">Nominas</a></li>
                    @endif
                </ul>
<!--                 <form class="navbar-form navbar-left" role="search" action="#">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="Buscar producto">
                    </div>
                    <button type="submit" class="btn btn-default">Buscar</button>
                </form> -->
            @endif
            <ul style="padding-top: 0.5em"class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    
                <div style=""class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    {{ Auth::user()->username }} <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Perfil</a></li>
                    <li><a href="{{route('user.cambioPassword')}}">Cambio Password</a></li>
                    </ul>
                </div>
                    @if (Auth::user()->isAdmin())
                        <div style=""class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Usuarios <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('auth.signup')}}">Gestión Usuarios</a></li>
                                <li><a href="{{route('fileentry')}}">Nominas</a></li>
                                <li><a href="{{url('events/calendario')}}">Vacaciones</a></li>
                                <li><a href="{{route('cuadrantes')}}">Horarios</a></li>
                            </ul>
                        </div>

                        
                        <div style=""class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Inventarios <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="{{route('plantillas.admin')}}">Plantillas</a></li>
                              <li><a href="{{route('inventarios.admin')}}">Inventarios</a></li>
                              <li><a href="{{route('control.create')}}">Informes</a></li>
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