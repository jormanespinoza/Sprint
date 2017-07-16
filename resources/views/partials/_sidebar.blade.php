<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a class="navbar-brand" href="{{ url('/admin') }}">
                3D String
            </a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "?s=40" . "?d=retro"}}" class="img-circle" alt="Avatar">
                {{ Auth::user()->first_name }} <span class="caret"></span><br>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('dashboard')}}">Perfil</a></li>
                <li role="separator" class="divider"></li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
        <li>
            <a href="/admin"><span class="glyphicon glyphicon-th-large"></span> Inicio</a>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> Usuarios <span class="caret"></span></a>
            <ul class="dropdown-menu">
            <li><a href="{{ url('admin/users') }}">Listado</a></li>
            <li><a href="{{ url('admin/users/create') }}">Crear</a></li>
            </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-briefcase"></span> Proyectos <span class="caret"></span></a>
            <ul class="dropdown-menu">
            <li><a href="{{ url('admin/projects') }}">Listado</a></li>
            <li><a href="{{ url('admin/projects/create') }}">Crear</a></li>
            </ul>
        </li>
        <li class="{{ Request::is('admin/contact') ? "active" : "" }}">
            <a href="{{ url('admin/contact') }}"> <span class="glyphicon glyphicon-envelope"></span> Contacto</a>
        </li>
        <li>
            <a href="#menu-hide" id="menu-hide" class="btn btn-block btn-default text-center fixed"><span class="glyphicon glyphicon-menu-left"></span> Ocultar Menú</a>
        </li>
    </ul>
</div>
<a href="#menu-show" class="btn btn-default" id="menu-show">Menú <span class="glyphicon glyphicon-menu-hamburger"></a>
