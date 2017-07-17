<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a class="navbar-brand" href="{{ url('/admin') }}">
                <span><img src="{{ url('images/logo.png')}}" alt="Logo de 3D Sprint" class="logo-navbar"></span> 
                {{ config('app.name', 'Laravel') }}
            </a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle sidebar-profile-item" data-toggle="dropdown" role="button" aria-expanded="false">
                <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "?d=retro"}}" class="img-circle admin-image" alt="Avatar">
                {{ Auth::user()->first_name }} <span class="caret"></span><br>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('dashboard')}}"><span class="glyphicon glyphicon-cog"></span> Perfil</a></li>
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
        <li class="{{ Request::is('admin') ? "active" : "" }}">
            <a href="/admin"><span class="glyphicon glyphicon-th-large"></span> Inicio</a>
        </li>
        <li class="{{ Request::is('admin/users') ? "active" : "" }}">
            <a href="/admin/users"><span class="glyphicon glyphicon-user"></span> Usuarios</a>
        </li>
        <li class="{{ Request::is('admin/projects') ? "active" : "" }}">
            <a href="/admin/projects"><span class="glyphicon glyphicon-folder-close"></span> Proyectos</a>
        </li>
        <li class="{{ Request::is('admin/contact') ? "active" : "" }}">
            <a href="{{ url('admin/contact') }}"> <span class="glyphicon glyphicon-envelope"></span> Contacto</a>
        </li>
        <li>
            <a href="#menu-hide" id="menu-hide" class="btn btn-md btn-default pull-right"><span class="glyphicon glyphicon-menu-left"></span></a>
        </li>
    </ul>
</div>
<div class="show-menu">
    <a href="#menu-show" class="btn btn-sm btn-default" id="menu-show">Menú <span class="glyphicon glyphicon-menu-right"></a>
</div>
