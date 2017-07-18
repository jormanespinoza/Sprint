@extends('layouts.admin')

@section('title', '| Proyectos')

@section('data')
    <ol class="breadcrumb">
        @include('partials._toggle_menu')
        <li>
            <a href="{{ url('admin') }}">
                <span class="glyphicon glyphicon-th-large"></span> Inicio
            </a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-folder-close"></span> Proyectos
        </li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8 col-xs-8">
                    <div class="heading-title">
                        Lista de Proyectos | <span class="label label-primary">
                            <strong>Total {{ count($all_projects) }}</strong></span>
                    </div>
                </div>
                <div class="col-md-4 col-xs-4">
                    <span class="pull-right">
                        <a href="{{ Route('projects.create') }}" class="btn btn-sm btn-primary" title="Crear Proyecto">
                            <span class="glyphicon glyphicon-file"></span> Nuevo
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>ID</th>
                        <th class="list-name">Nombre</th>
                        <th>Descripción</th>
                        <th class="actions">Acciones</th>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <th>{{ $project->id }}</th>
                                <td>{{ $project->name }}</td>
                                <td>{{ substr(strip_tags($project->description), 0, 110) }} {{ strlen(strip_tags($project->description)) > 110 ? '...' : '' }}</td>
                                <td>
                                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-xs btn-default" title="Abrir"><span class="glyphicon glyphicon-folder-open"></span></a>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-xs btn-warning" title="Editar"><span class="glyphicon glyphicon-edit"></span></a>

                                    <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" role="button" data-target="#confirmationModal-{{ $project->id }}" title="Eliminar">
                                        <span class="glyphicon glyphicon-remove-sign" ></span>
                                    </button>

                                    {{-- Confirmation Modal --}}
                                    <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal-{{ $project->id }}">
                                        <div class="modal-dialog" role="dialog" id="model-{{ $project->id }}">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">3D Sprint - Confirmación</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Seguro deseas eliminar el proyecto <strong>{{ $project->name }}</strong>?</p>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $projects->links( )}}
            </div>
        </div>
    </div>
@endsection