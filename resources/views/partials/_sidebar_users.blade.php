<div id="sidebar-wrapper">
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
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="{{ url($dashboard) }}">
                {{ config('app.name', 'Laravel') }}
                <span id="main_icon"><img src="{{ url('images/logo.png')}}" alt="Logo de 3D Sprint" class="logo-navbar"></span>
            </a>
        </li>
        <li>
            <ul class="sidebar-nav" id="sidebar">
                <li class="{{ Request::is('dashboard') ? " active " : " " }}">
                    <a href="/dashboard">Dashboard<span class="sub_icon glyphicon glyphicon-dashboard" title="Proyectos"></span></a>
                </li>
                <li>
                    <a role="button" data-toggle="collapse" href="#collapseProjects" aria-expanded="false" aria-controls="collapseProjects" id="collapse">
                        Proyectos<span class="sub_icon glyphicon glyphicon-folder-open" title="Proyectos"></span>
                    </a>
                </li>
                <div class="collapse" id="collapseProjects">
                    @foreach(Auth::user()->projects as $project)
                        <li class="sidebar-projects {{ Request::is('project/' . $project->id . '*') ? " active " : " " }}">
                            <a href="{{ route('project.show', $project->id) }}">
                                {{ substr($project->name, 0, 9) }} {{ strlen($project->name) > 9 ? '...' : '' }}<span class="sub_icon glyphicon glyphicon-file" title="{{ $project->name }}"></span>
                            </a>
                        </li>
                    @endforeach
                </div>
            </ul>
        </li>
        <li class="sidebar-user location">
            @php
                # check the user role to assing a specific class to it
                switch (Auth::user()->role_id) {
                    case 1:
                        $label_class = 'label-success';
                        break;
                    case 2:
                        $label_class = 'label-primary';
                        break;
                    case 3:
                        $label_class = 'label-info';
                        break;
                    default:
                        $label_class = 'label-default';
                        break;
                }
            @endphp
            <a role="button" data-toggle="collapse" href="#collapseUser" aria-expanded="false" aria-controls="collapseProjects" id="collapseUserOptions" class="sidebar-profile-item">
                <span class="sidebar-user-data">
                    {{ Auth::user()->first_name }}<br>
                    <span class="label {{ $label_class }} sidebar-user-status" style="padding-left: 12%;"><b>{{ Auth::user()->role->name }}</b></span>
                </span>
                <span id="user_icon"><img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "?d=retro"}}" class="img-circle admin-image" alt="Avatar"></span>
            </a>
        </li>
    </ul>
</div>