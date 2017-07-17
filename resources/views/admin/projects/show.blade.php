@extends('layouts.admin')

@section('title', '| Proyecto ' . $project->name)

@section('data')
    <ol class="breadcrumb">
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

    <h1>{{ $project->name }}</h1>
    <div class="well">{!! $project->description !!}</div>
    <p class="text-right">
        <strong>Creado:</strong> {{ $project->created_at->diffForHumans() }} | 
        <strong>Última Actualización:</strong> {{ $project->updated_at->diffForHumans() }}
    </p>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="show-actions-btn text-right">
                <a href="{{ route('projects.edit', $project->id) }}" class="well text-center">
                    <span class="glyphicon glyphicon-edit"></span> Editar
                </a>

                <a href="" class="well text-center" type="button" data-toggle="modal" data-target="#confirmationModal" title="Eliminar">
                    <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                </a>
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
