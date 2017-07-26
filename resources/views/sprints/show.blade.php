@extends('layouts.app')

@section('title', '| Sprint ' . $sprint->name)

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}">
                <span class="glyphicon glyphicon-folder-close"></span> Proyectos
            </a>
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
                            <span style="text-transform:none;">(Editado por {{ $editor->first_name }})</span>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->role_id != 4)
                    <div class="col-md-4 col-xs-6">
                        @if(Auth::user()->role_id == 2)
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
                        @endif
                        @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
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
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="well" title="Descripción del Proyecto">
        {!! $sprint->description !!}
    </div>

    <div class="row list-group">
        <div class="col-md-4 col-md-offset-8 col-sm-6 col-sm-offset-6 text-center">
            <div class="list-group-item">
                <span class="glyphicon glyphicon-calendar text-success"></span> <span class="text-success date-font-size"> Inicia: {{ $sprint->starts_on }}</span>
                | 
                <span class="glyphicon glyphicon-calendar text-danger"></span> <span class="text-danger date-font-size"> Cierra: {{ $sprint->ends_on }}</span>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-9 col-xs-7">
            <h5>
                <span class="glyphicon glyphicon-tasks"></span> Tareas 
                @if(Auth::user()->role_id != 4 && $task_total_hours > 0)
                    | <small>
                         Horas <span class="badge">{{ $task_total_hours }}
                    </small>
                @endif
            </h5>
        </div>
        <div class="col-md-3 col-xs-5">
            @if(Auth::user()->role_id != 4)
                <div class="btn-new-task text-right">
                    <a href="{{ route('task.create', [$project->id, $sprint->id]) }}" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-file"></span> Añadir Tarea</a>
                </div>
            @endif
        </div>
    </div>

    @if(count($tasks ) > 0)
        @if(Auth::user()->role_id != 4)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th class="task-name">Nombre</th>
                        <th>Descripción</th>
                        <th>Horas</th>
                        <th>
                            Estatus 
                            <a type="button" data-toggle="modal" data-target="#statusModal" title="Estados">
                                 <span class="glyphicon glyphicon-info-sign"></span>
                            </a>
                        </th>
                        <th class="task-actions">Acciones</th>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->name }}</td>
                                <td>{{ substr(strip_tags($task->description), 0, 110) }} {{ strlen(strip_tags($task->description)) > 110 ? '...' : '' }}</td>
                                <td>{{ $task->hours }}</td>
                                <td>
                                    @php
                                        switch ($task->status->id) {
                                            case 1:
                                                $label_class = 'label-default';
                                                break;
                                            case 2:
                                                $label_class = 'label-info';
                                                break;
                                            case 3:
                                                $label_class = 'label-primary';
                                                break;
                                            case 4:
                                                $label_class = 'label-danger';
                                                break;
                                            case 5:
                                                $label_class = 'label-success';
                                                break;
                                            default:
                                                $label_class = 'label-default';
                                                break;
                                        } 
                                    @endphp
                                     <span class="label {{ $label_class }}">
                                        <b>{{ $task->status->name }}</b>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $tasks->links() }}
            </div>
            @if($task_total_hours > 0)
                <div class="row list-group">
                    <div class="col-md-4 col-md-offset-8 col-sm-6 col-sm-offset-6 text-center">
                        <div class="list-group-item">
                            Cantidad de Horas Acumuladas <span class="badge">{{ $task_total_hours }}
                        </div> 
                    </div>
                </div>
            @endif
        @else
            <div class="list-group">
                @foreach($tasks as $task)
                    <a class="list-group-item list-group-item-action">
                        <span class="glyphicon glyphicon-erase"></span> {{ $task->name }}
                        <span class="glyphicon glyphicon-new-window pull-right" title="Abrir Tarea"></span>
                    </a>
                @endforeach
            </div>
            <div class="text-center">
                {{ $tasks->links() }}
            </div>
        @endif
    @else
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-info-sign"></span> No se han registrado tareas para el Sprint.
        </div>
    @endif

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

    {{-- Status Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="statusModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Estados de las Tareas</h4>
                </div>
                <div class="modal-body">
                    {{-- Statuses --}}
                    <div class="text-center">
                        <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapsePending" aria-expanded="false" aria-controls="collapsePending">Pendiente</button>
                        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#collapseApproved" aria-expanded="false" aria-controls="collapseApproved">Aprobado</button>
                        <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#collapseToConfirm" aria-expanded="false" aria-controls="collapseToConfirm">Por Confirmar</button>
                        <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#collapseRejected" aria-expanded="false" aria-controls="collapseRejected">Rechazado</button>
                        <button type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseConfirmed" aria-expanded="false" aria-controls="collapseConfirmed">Confirmado</button>
                    </div>
                    {{-- Statuses Descriptions--}}
                    <div class="status-description">
                        <div class="collapse" id="collapsePending">
                            <hr>
                            <div class="alert alert-default">
                                <span class="glyphicon glyphicon-file"></span> {{ $statuses[1] }}
                            </div>
                        </div>
                        <div class="collapse" id="collapseApproved">
                            <hr>
                            <div class="alert alert-info">
                                <span class="glyphicon glyphicon-ok-circle"></span> {{ $statuses[2] }}
                            </div>
                        </div>
                        <div class="collapse" id="collapseToConfirm">
                            <hr>
                            <div class="alert alert-default">
                                <span class="text-primary"><span class="glyphicon glyphicon-edit"></span> {{ $statuses[3] }}</span>
                            </div>
                        </div>
                        <div class="collapse" id="collapseRejected">
                            <hr>
                            <div class="alert alert-danger">
                                <span class="glyphicon glyphicon-repeat"></span> {{ $statuses[4] }}
                            </div>
                        </div>
                        <div class="collapse" id="collapseConfirmed">
                            <hr>
                            <div class="alert alert-success">
                                <span class="glyphicon glyphicon-check"></span> {{ $statuses[5] }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <i class="glyphicon glyphicon-thumbs-up"></i> Bien!
                            </button>
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection