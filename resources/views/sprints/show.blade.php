@extends('layouts.app')

@section('title', '| Sprint ' . $sprint->name)

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}"><span class="glyphicon glyphicon-folder-close"></span> Proyectos</a>
        </li>
        <li>
            <a href="{{ route('project.show', $project->id) }}">
                <span class="glyphicon glyphicon-folder-open"></span> {{ $project->name }}
            </a>
        </li>
        <li>
            <a href="{{ route('project.show', $project->id) }}">
                <span class="glyphicon glyphicon-inbox"></span> Sprints
            </a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-open-file"></span> {{ $sprint->name }}
        </li>
    </ol>
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8 col-xs-6">
                    <div class="{{ Auth::user()->role_id != 4 ? "project-title" : "" }}">
                        <span>{{ $sprint->name }}</span>
                        @if($sprint->edited && Auth::user()->role_id != 4)
                            <span style="text-transform:none;">(Editado por: {{ $editor->first_name }})</span>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->role_id != 4)
                    @if(!$sprint->edited || Auth::user()->role_id == 2)
                        <div class="col-md-4 col-xs-6">
                            <div class="pull-right">
                                {{-- Web View --}}
                                <a class="btn btn-block btn-default actions-show-project-web" type="button" data-toggle="modal" data-target="#confirmationModal" title="Eliminar">
                                    <span class="glyphicon glyphicon-remove-circle"></span> Eliminar
                                </a>
                                {{-- Mobile View --}}
                                <a class="btn btn-sm btn-default actions-show-project-mobile" type="button" data-toggle="modal" data-target="#confirmationModal" title="Eliminar">
                                    <span class="glyphicon glyphicon-remove-circle"></span>
                                </a>
                            </div>
                            <div class="pull-right">
                                {{-- Web View --}}
                                <a href="{{ route('sprint.edit', [$project->id, $sprint->id]) }}" class="btn btn-block btn-default actions-show-project-web" title="Editar">
                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                </a>
                                {{-- Mobile View --}}
                                <a href="{{ route('sprint.edit', [$project->id, $sprint->id]) }}" class="btn btn-sm btn-default actions-show-project-mobile" title="Editar">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                            </div>
                        </div>
                    @endif
                    
                @endif
            </div>
        </div>
    </div>

    <div class="well" title="Descripción del Proyecto">
        {!! $sprint->description !!}
    </div>

    <div class="col-md-5 col-md-offset-7 text-right">
        <span class="glyphicon glyphicon-calendar text-success"></span> <span class="text-success date-font-size"> Inicia: {{ $sprint->starts_on }}</span>
        | 
        <span class="glyphicon glyphicon-calendar text-danger"></span> <span class="text-danger date-font-size"> Cierra: {{ $sprint->ends_on }}</span>
    </div>

    <br>

    <h5><span class="glyphicon glyphicon-tasks"></span> Tareas </h5>
    <hr>

    <div class="well">
        @if(Auth::user()->role_id == 3)
            <div class="btn-new-task text-right">
                <a href="" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-file"></span> Añadir Nueva Tarea</a>
            </div>
        @endif

        <div class="clearfix"></div>

        <div class="list-group">
            <a href="" class="list-group-item list-group-item-action">
                <span class="glyphicon glyphicon-file"></span> Tarea
                <span class="glyphicon glyphicon-folder-open pull-right" title="Abrir Proyecto"></span>
            </a>
            <a href="" class="list-group-item list-group-item-action">
                <span class="glyphicon glyphicon-file"></span> Tarea 2
                <span class="glyphicon glyphicon-folder-open pull-right" title="Abrir Proyecto"></span>
            </a>
            <a href="" class="list-group-item list-group-item-action">
                <span class="glyphicon glyphicon-file"></span> Tarea 3
                <span class="glyphicon glyphicon-folder-open pull-right" title="Abrir Proyecto"></span>
            </a>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <p>¿Seguro deseas eliminar este sprint?</p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="glyphicon glyphicon-remove-sign"></i> No
                            </button>
                        </li>

                        <li>
                            {{ Form::open(['route' => ['sprint.destroy', $project->id, $sprint->id]]) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection