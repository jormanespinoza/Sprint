<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            @php
                if(Auth::check()) {
                    if (Auth::user()->role_id == 1) {
                       $dashboard = 'admin';
                    }else {
                        $dashboard = 'dashboard';
                    }
                }else {
                    $dashboard = '/';
                }
            @endphp
            <a class="navbar-brand" href="{{ url($dashboard) }}">
                <span><img src="{{ url('images/logo.png')}}" alt="Logo de 3D Sprint" class="logo-navbar"></span>
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav"></ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> Ingresar</a></li>
                    <li><a href="{{ route('register') }}"><span class="glyphicon glyphicon-check"></span> Registrarse</a></li>
                @else
                    <li class="{{ Request::is('contact') ? "active" : "" }}"><a href="/contact">Contacto</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                 <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "?d=retro" }}" class="img-circle user-image" alt="Avatar">
                                {{ Auth::user()->first_name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('dashboard')}}"><span class="glyphicon glyphicon-cog"></span>  Perfil</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>