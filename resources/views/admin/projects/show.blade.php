@extends('layouts.admin')

@section('title', '| Proyecto ' . $project->name)

@section('data')
    <ol class="breadcrumb">
        @include('partials._toggle_menu')
        <li>
            <a href="{{ url('admin') }}"><span class="glyphicon glyphicon-th-large"></span> Inicio</a>
        </li>
        <li>
            <a href="{{ url('admin/projects') }}"><span class="glyphicon glyphicon-folder-close"></span> Proyectos</a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-folder-open"></span> {{ $project->name }}
        </li>
    </ol>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8 col-xs-6">
                    <div class="heading-title">
                        <span style="text-transform: uppercase;">Proyecto {{ $project->name }}</span>
                    </div>
                </div>
                <div class="col-md-4 col-xs-6">
                    <div class="pull-right">
                        <a class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#confirmationModal" title="Eliminar">
                            <span class="glyphicon glyphicon-remove-sign"></span>
                        </a>
                    </div>
                     <div class="pull-right">
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning" title="Editar">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="well" title="Descripción del Proyecto">
        {!! $project->description !!}
    </div>

    <div class="col-md-4">
        <h5>
            <span class="glyphicon glyphicon-tags text-right"></span> Asignar Usuarios
        </h5>
        <hr>
        <div class="well">
            <button type="button" class="btn btn-block btn-primary">
                <span class="glyphicon glyphicon-bookmark"></span> Líder de Proyecto
            </button>
            <button type="button" class="btn btn-block btn-info">
                <span class="glyphicon glyphicon-cog"></span> Desarrollador
            </button>
            <button type="button" class="btn btn-block btn-default">
                <span class="glyphicon glyphicon-user"></span> Cliente
            </button>
        </div>
    </div>

    <div class="col-md-8">
        <h5>
            <span class="glyphicon glyphicon-list-alt"></span> Información del Proyecto
        </h5>
        <hr>
        <div class="well">
            <div class="list-group">
                <div class="list-group-item">
                    <h4><strong class="label label-primary">Líder de Proyecto</strong></h4>
                    @if($assigned_leader)
                        <ul class="list-group">
                            @foreach($project->users as $user)
                                @if($user->role_id == 2)
                                    <a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item-action">
                                            {{ $user->last_name }} {{ $user->first_name }}
                                    </a>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-default">
                            <span class="glyphicon glyphicon-info-sign"></span>De momento no se encuentra asignado un líder de proyecto. 
                        </div>
                    @endif
                </div>
            </div>
            <div class="list-group">
                <div class="list-group-item">
                    <h4><strong class="label label-info">Desarrollador</strong></h4>
                    @if($assigned_developer)
                        <ul class="list-group">
                            @foreach($project->users as $user)
                                @if($user->role_id == 3)
                                    <a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item-action">
                                            {{ $user->last_name }} {{ $user->first_name }}
                                    </a>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-default">
                            <span class="glyphicon glyphicon-info-sign"></span>De momento no se encuentra asignado un desarrolador para el proyecto. 
                        </div>
                    @endif
                </div>
            </div>
            <div class="list-group">
                <div class="list-group-item">
                    <h4><strong class="label label-default">Cliente</strong></h4>
                    @if($assigned_client)
                        <ul class="list-group">
                            @foreach($project->users as $user)
                                @if($user->role_id == 4)
                                    <a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item-action">
                                            {{ $user->last_name }} {{ $user->first_name }}
                                    </a>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-default">
                            <span class="glyphicon glyphicon-info-sign"></span>De momento no se encuentra asignado un cliente para el proyecto. 
                        </div>
                    @endif
                </div>
            </div>
            <hr>
            <div class="list-group">
                <div class="list-group-item">
                    <strong>Creado:</strong> {{ $project->created_at->diffForHumans() }}
                </div>
                <div class="list-group-item">
                    <strong>Última Actualización:</strong> {{ $project->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">3D Sprint - Confirmación</h4>
                </div>
                <div class="modal-body">
                    <p>¿Seguro deseas eliminar este proyecto?</p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </li>

                        <li>
                            {{ Form::open(['route' => ['projects.destroy', $project->id]]) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::submit('Sí', ['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
