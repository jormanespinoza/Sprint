@extends('layouts.app')

@section('title', '| Proyectos')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8 col-xs-8">
                            <div class="heading-title">
                                Lista de Proyectos | <span class="label label-primary">Total {{ count($projects) }} </span>
                            </div>
                        </div>
                       <div class="col-md-4 col-xs-4">
                            <span class="pull-right">
                                <a href="{{ Route('projects.create') }}" class="btn btn-block btn-primary" title="Crear Proyecto">
                                    <span class="glyphicon glyphicon-briefcase"></span> Nuevo
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
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <th>{{ $project->id }}</th>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ substr(strip_tags($project->description), 0, 75) }} {{ strlen(strip_tags($project->description)) > 75 ? '...' : '' }}</td>
                                        <td>
                                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-xs btn-default" title="Abrir"><span class="glyphicon glyphicon-folder-open"></span></a>
                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-xs btn-warning" title="Editar"><span class="glyphicon glyphicon-edit"></span></a>
                                            <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirmationModal" title="Eliminar"><span class="glyphicon glyphicon-remove-sign"></span></button>
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
@endsection

@section('scripts')
    <script>
        $('#confirmationModal').on('shown.bs.modal', function () {
            $('#delete-button').focus()
        })
    </script>
@endsection