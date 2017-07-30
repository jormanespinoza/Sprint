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
            <a href="/admin/projects" class="btn btn-success admin-dashboard-link">
                <span class="glyphicon glyphicon-folder-close"></span> Proyectos
            </a> | <small>Total <span class="badge">{{ count($all_projects) }}</span></small>
            <a href="{{ Route('projects.create') }}" class="btn btn-link pull-right" title="Crear Proyecto">
                <span class="glyphicon glyphicon-file"></span> Nuevo
            </a>
        </h5>
        <hr>

        <div class="list-group">
            @if(count($projects) > 0)
                @foreach($projects->sortBy('created_at') as $project)
                    {{ $all_sprints_done = false }}
                    @if(count($project->sprints) > 0)
                        @foreach($project->sprints as $sprint)
                            @php
                                $all_sprints_done = true;
                                if (!$sprint->done) {
                                    $all_sprints_done = false;
                                }
                            @endphp
                        @endforeach
                    @endif
                    <a href="{{ route('projects.show', $project->id) }}" class="list-group-item list-group-item-{{ $all_sprints_done ? "success " : "action"}}">
                        <span class="glyphicon glyphicon-file"></span> {{ $project->name }}
                        <span class="glyphicon glyphicon-folder-open pull-right" title="Abrir Proyecto"></span>
                    </a>
                @endforeach
            @else
                <p class="list-group-item list-group-item-action">No se encuentran proyectos generados en el sistema.</p>
            @endif
        </div>
        <div class="text-center">
            {{ $projects->links() }}
        </div>
    </div>

    <div class="col-md-5">
        <h5>
            <a href="/admin/users" class="btn btn-primary admin-dashboard-link">
            <span class="glyphicon glyphicon-tags"></span> Usuarios
            </a> | <small>Total <span class="badge">{{ count($leaders) + count($developers) + count($clients)  }}</span></small>
            <a href="{{ Route('users.create') }}" class="btn btn-link pull-right" title="Crear Usuario">
                <span class="glyphicon glyphicon-user"></span> Nuevo
            </a>
        </h5>
        <hr>

        <button type="button" class="btn btn-block btn-primary" data-toggle="collapse" data-target="#leaders"><span class="glyphicon glyphicon-bookmark">
            </span> Líderes de Proyecto <span class="badge">{{ count($leaders) }}</span><span class="glyphicon glyphicon glyphicon-list pull-right"></span>
        </button>

        <div id="leaders" class="collapse">
            <div class="list-group">
                @if(count($leaders) > 0)
                    @foreach($leaders as $leader)
                        <a href="{{ route('users.show', $leader->id) }}" class="list-group-item list-group-item-action">
                            <span class="glyphicon glyphicon-tag"></span> {{ $leader->last_name }} {{ $leader->first_name }}
                            <span class="glyphicon glyphicon-info-sign pull-right" title="Información del Usuario"></span>
                        </a>
                    @endforeach
                @else
                    <p class="list-group-item list-group-item-action">No se encuentran líderes generados en el sistema.</p>
                @endif
            </div>
        </div>
        <hr>

        <button type="button" class="btn btn-block btn-info" data-toggle="collapse" data-target="#developers"><span class="glyphicon glyphicon-cog">
            </span> Desarrolladores <span class="badge">{{ count($developers) }}</span><span class="glyphicon glyphicon-list pull-right"></span>
        </button>

        <div id="developers" class="collapse">
            <div class="list-group">
                @if(count($developers) > 0)
                    @foreach($developers as $developer)
                        <a href="{{ route('users.show', $developer->id) }}" class="list-group-item list-group-item-action">
                            <span class="glyphicon glyphicon-tag"></span> {{ $developer->last_name }} {{ $developer->first_name }}
                            <span class="glyphicon glyphicon-info-sign pull-right" title="Información del Usuario"></span>
                        </a>
                    @endforeach
                @else
                    <p class="list-group-item list-group-item-action">No se encuentran desarrolladores generados en el sistema.</p>
                @endif
                
            </div>
        </div>
        <hr>

        <button type="button" class="btn btn-block btn-default " data-toggle="collapse" data-target="#clients"><span class="glyphicon glyphicon-user">
            </span> Clientes <span class="badge">{{ count($clients) }}</span><span class="glyphicon glyphicon-list pull-right"></span>
        </button>

        <div id="clients" class="collapse">
            <div class="list-group">
                @if(count($clients) > 0)
                    @foreach($clients as $client)
                        <a href="{{ route('users.show', $client->id) }}" class="list-group-item list-group-item-action">
                            <span class="glyphicon glyphicon-tag"></span> {{ $client->last_name }} {{ $client->first_name }}
                            <span class="glyphicon glyphicon-info-sign pull-right" title="Información del Usuario"></span>
                        </a>
                    @endforeach
                @else
                    <p class="list-group-item list-group-item-action">No se encuentran clientes generados en el sistema.</p>
                @endif
            </div>
        </div>
    </div>
@endsection