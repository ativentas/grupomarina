<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Grupo Marina</a>
        </div>
        <div class="collapse navbar-collapse">
            @if (Auth::check())
                <ul class="nav navbar-nav">
                    <li><a href="{{route('pedidos.abiertos')}}">Pedidos Abiertos</a></li>
                    <li><a href="{{route('pedidos.completos')}}">Ultimos</a></li>
                </ul>
                <form class="navbar-form navbar-left" role="search" action="#">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="Buscar producto">
                    </div>
                    <button type="submit" class="btn btn-default">Buscar</button>
                </form>
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li><a href="#">{{ Auth::user()->username }}</a></li>
                    <li><a href="#">Mi Perfil</a></li>
                    @if (Auth::user()->username === 'jose')
                        <li><a href="{{route('auth.signup')}}">Usuarios</a></li>
                    @endif
                    <li><a href="{{route('auth.signout')}}">Salir</a></li>

                @else
                    
                    <li><a href="{{route('auth.signin')}}">Entrar</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>