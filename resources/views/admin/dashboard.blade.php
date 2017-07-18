@extends('layouts.admin')

@section('title' ,'| Panel de Administración')

@section('data')
    <ol class="breadcrumb">
        @include('partials._toggle_menu')
        <li class="active">
            <span class="glyphicon glyphicon-th-large"></span> Inicio
        </li>
    </ol>
     <div class="col-md-7">
        <h5>
            <a href="/admin/projects" class="admin-dashboard-link">
                <span class="glyphicon glyphicon-folder-close"></span> Proyectos</a> | 
            <small>Total <span class="badge">{{ count($projects) }}</span></small>
        </h5>
        <hr>
        <div class="list-group">
            @if(count($projects) > 0)
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->id) }}" class="list-group-item list-group-item-action">
                        <span class="glyphicon glyphicon-file"></span> {{ $project->name }}: {{ substr(strip_tags($project->description), 0, 80) }} {{ strlen(strip_tags($project->description)) > 80 ? '...' : '' }}
                    </a>
                @endforeach
            @else
                <p class="list-group-item list-group-item-action">De momento no se encuentran proyectos generados.</p>
            @endif
            
        </div>
        <div class="text-center">
            {{ $projects->links() }}
        </div>
    </div>

    <div class="col-md-5">
        <h5>
            <a href="/admin/users" class="admin-dashboard-link"><span class="glyphicon glyphicon-tags"></span> Usuarios</a> | 
            <small>Total <span class="badge">{{ count($leaders) + count($developers) + count($clients)  }}</span></small>
        </h5>
        <hr>
        <button type="button" class="btn btn-block btn-primary" data-toggle="collapse" data-target="#leaders"><span class="glyphicon glyphicon-bookmark"></span> Líderes de Proyecto <span class="badge">{{ count($leaders) }}</span><span class="glyphicon glyphicon glyphicon-th-list pull-right"></span></button>
        <div id="leaders" class="collapse">
            <div class="list-group">
                @if(count($leaders) > 0)
                    @foreach($leaders as $leader)
                        <a href="{{ route('users.show', $leader->id) }}" class="list-group-item list-group-item-action">
                            <span class="glyphicon glyphicon-tag"></span> {{ $leader->last_name }} {{ $leader->first_name }}
                        </a>
                    @endforeach
                @else
                    <p class="list-group-item list-group-item-action">De momento no se encuentran líderes generados.</p>
                @endif
            </div>
        </div>
        <hr>
        <button type="button" class="btn btn-block btn-info" data-toggle="collapse" data-target="#developers"><span class="glyphicon glyphicon-cog"></span> Desarrolladores <span class="badge">{{ count($developers) }}</span><span class="glyphicon glyphicon-th-list pull-right"></span></button>
        <div id="developers" class="collapse">
            <div class="list-group">
                @if(count($developers) > 0)
                    @foreach($developers as $developer)
                        <a href="{{ route('users.show', $developer->id) }}" class="list-group-item list-group-item-action">
                            <span class="glyphicon glyphicon-tag"></span> {{ $developer->last_name }} {{ $developer->first_name }}
                        </a>
                    @endforeach
                @else
                    <p class="list-group-item list-group-item-action">De momento no se encuentran desarrolladores generados.</p>
                @endif
                
            </div>
        </div>
        <hr>
        <button type="button" class="btn btn-block btn-default " data-toggle="collapse" data-target="#clients"><span class="glyphicon glyphicon-user"></span> Clientes <span class="badge">{{ count($clients) }}</span><span class="glyphicon glyphicon-th-list pull-right"></span></button>
        <div id="clients" class="collapse">
            <div class="list-group">
                @if(count($clients) > 0)
                    @foreach($clients as $client)
                        <a href="{{ route('users.show', $client->id) }}" class="list-group-item list-group-item-action">
                            <span class="glyphicon glyphicon-tag"></span> {{ $client->last_name }} {{ $client->first_name }}
                        </a>
                    @endforeach
                @else
                    <p class="list-group-item list-group-item-action">De momento no se encuentran clientes generados.</p>
                @endif
            </div>
        </div>
    </div>
@endsection