<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="{{ url('/admin') }}">
                {{ config('app.name', 'Laravel') }}
                <span id="main_icon"><img src="{{ url('images/logo.png')}}" alt="Logo de 3D Sprint" class="logo-navbar"></span>
            </a>
        </li>
        <li>
            <ul class="sidebar-nav" id="sidebar">
                <li class="{{ Request::is('admin') ? " active " : " " }}">
                    <a href="/admin">Dashboard<span class="sub_icon glyphicon glyphicon-dashboard" title="Dashboard"></span></a>
                </li>
                <li class="{{ Request::is('admin/projects') ? " active " : " " }}">
                    <a href="/admin/projects">Proyectos<span class="sub_icon glyphicon glyphicon-folder-close" title="Proyectos"></span></a>
                </li>
                <li class="{{ Request::is('admin/users') ? " active " : " " }}">
                    <a href="/admin/users">Usuarios<span class="sub_icon glyphicon glyphicon-user" title="Usuarios"></span></a>
                </li>
            </ul>
        </li>
        <li class="sidebar-user location">
            <a role="button" data-toggle="collapse" href="#collapseUser" aria-expanded="false" aria-controls="collapseProjects" id="collapseUserOptions" class="sidebar-profile-item">
                <span class="sidebar-user-data">
                    {{ Auth::user()->first_name }}<br>
                    <span class="label label-success sidebar-user-status" style="padding-left: 10%;"><b>{{ Auth::user()->role->name }}</b></span>
                </span>
                <span id="user_icon"><img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "?d=retro"}}" class="img-circle admin-image" alt="Avatar"></span>
            </a>
        </li>
    </ul>
</div>