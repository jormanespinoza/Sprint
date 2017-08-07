@extends('layouts.app')

@section('title', '| ' . $sprint->name)

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}">
                <span class="glyphicon glyphicon-dashboard"></span> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('project.show', $project->id) }}">
                <span class="glyphicon glyphicon-folder-open"></span> {{ $project->name }}
            </a>
        </li>
        <li>
            <a href="{{ route('project.show', $project->id) }}">
                <span class="glyphicon glyphicon-tasks"></span> Sprints
            </a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-copy"></span> {{ $sprint->name }}
        </li>
    </ol>

    @if(Auth::user()->role_id != 4)
        @if($task_total_hours == $sprint->hours)
            <div class="col-md-12 list-group">
                <div class="list-group-item">
                {{ Form::open(['route' => ['task.store', $project->id, $sprint->id], 'novalidate' => '']) }}
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-9 col-sm-9">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Agrega tareas acá...', 'disabled' => 'disabled']) }}
                                    <span class="input-group-addon" id='name'><span class="glyphicon glyphicon-tag"></span></span>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-2">
                            <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    {!! Form::number('hours', $sprint->hours, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    <span class="input-group-addon" id='hours'><span class="glyphicon glyphicon-time"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1 col-sm-1">
                            <button type="submit" class="btn btn-block btn-success" title="Horas Completas" disabled><i class="glyphicon glyphicon-play-circle"></i></button>
                        </div>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        @else
            <div class="col-md-12 list-group">
                <div class="list-group-item">
                {{ Form::open(['route' => ['task.store', $project->id, $sprint->id], 'novalidate' => '']) }}
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-9 col-sm-9">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Agrega tareas acá...']) }}
                                    <span class="input-group-addon" id='name'><span class="glyphicon glyphicon-tag"></span></span>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-2">
                            <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    {!! Form::select('hours', $task_hours, null, ['class' => 'form-control']) !!}
                                    <span class="input-group-addon" id='hours'><span class="glyphicon glyphicon-time"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1 col-sm-1">
                            <button type="submit" class="btn btn-block btn-success" title="Crear Tarea"><i class="glyphicon glyphicon-play-circle"></i></button>
                        </div>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        @endif
    @endif

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-9 col-xs-7">
                <span class="glyphicon glyphicon-tasks"></span> {{ $sprint->name }} 
                @if($sprint->description != null)
                    <a type="button" data-toggle="modal" data-target="#sprintDescriptionModal" title="Información">
                        <i class="glyphicon glyphicon-option-vertical"></i>
                    </a>
                @endif
            </div>
            <div class="col-md-3 col-xs-5 text-right">
                <b>{{ $task_total_hours }}</b>/{{ $sprint->hours }} horas
            </div>
        </div>
    </div>

    @if(count($tasks ) > 0)
        <div class="table-responsive">
            <table class="table" id="tasks-table">
                <thead>
                    <th class="col-md-10"></th>
                    <th class="col-md-1"></th>
                    <th class="col-md-1"></th>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        @php
                            switch ($task->status->id) {
                                case 1:
                                    $_class = 'default';
                                    $_icon = 'fullscreen';
                                    $_status = 'task-pending';
                                    break;
                                case 2:
                                    $_class = 'info';
                                    $_icon = 'ok';
                                    $_status = 'task-approved';
                                    break;
                                case 3:
                                    $_class = 'warning';
                                    $_icon = 'unchecked';
                                    $_status = 'task-check';
                                    break;
                                case 4:
                                    $_class = 'danger';
                                    $_icon = 'repeat';
                                    $_status = 'task-rejected';
                                    break;
                                case 5:
                                    $_class = 'success';
                                    $_icon = 'check';
                                    $_status = 'task-confirmed';
                                    break;
                                default:
                                    $_class = 'default';
                                    $_icon = 'fullscreen';
                                    $_status = 'task-pending';
                                    break;
                            }
                        @endphp
                        <tr class="{{ $_status }}">
                            <td class="task-table-text">{{ substr($task->name, 0, 150) }} {{ strlen($task->name) > 150 ? '...' : '' }}</td>
                            <td class="task-table-text">
                                @if(Auth::user()->role_id == 2 && $task->status_id == 1)
                                    {{-- Edit Task --}}
                                    <button type="button" class="btn btn-xs btn-link" data-toggle="modal" role="button" data-target="#editTaskModal-{{ $task->id }}" title="Editar" data-dismiss="modal">
                                        <span class="glyphicon glyphicon-fullscreen"></span>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-xs btn-link" data-toggle="modal" role="button" data-target="#showTaskModal-{{ $task->id }}" title="{{ $task->status->name }}">
                                        <span class="glyphicon glyphicon-{{ $_icon }}" ></span>
                                    </button>
                                @endif

                                {{-- Show Task Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="showTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog modal-lg" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">
                                                    <span class="glyphicon glyphicon-erase"></span> {{ $task->name}}
                                                        | <span class="label label-{{ $_class }}"><strong>{{ $task->status->name }}</strong></span>
                                                </h4>
                                            </div>

                                            <div class="modal-body">
                                                {!! $task->description !!}
                                                <div class="list-group" style="padding-bottom: 5px;">
                                                    <div class="col-md-2 col-md-offset-10 col-sm-6 col-sm-offset-6 text-center">
                                                        <div class="list-group-item">
                                                            {{ $task->hours }} {{ $task->hours > 1 ? "horas" : "hora" }}
                                                        </div> 
                                                    </div>
                                                </div>
                                                <br>

                                                @if(count($task->observations) > 0)
                                                    <span class="glyphicon glyphicon-send"></span> Notas

                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-1">
                                                            @foreach($task->observations as $observation)
                                                                <div class="row task-comments">
                                                                    <div class="col-md-1 col-sm-2 col-xs-3">
                                                                        <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($observation->user->email))) . "?d=retro" }}" class="img-circle user-observation" alt="Avatar">
                                                                    </div>

                                                                    <div class="col-md-2 col-sm-10 col-xs-9">
                                                                        {{ $observation->user->first_name }}
                                                                        @php
                                                                            switch ($observation->user->role_id) {
                                                                                case 1:
                                                                                    $_class = 'success';
                                                                                    break;
                                                                                case 2:
                                                                                    $_class = 'info';
                                                                                    break;
                                                                                case 3:
                                                                                    $_class = 'primary';
                                                                                    break;
                                                                                case 4:
                                                                                    $_class = 'default';
                                                                                    break;
                                                                                default:
                                                                                    $_class = 'default';
                                                                                    break;
                                                                            }
                                                                        @endphp
                                                                        <span class="label label-{{ $_class }}"><b>{{ $observation->user->role->name }}</b></span>
                                                                    </div>

                                                                    <div class="col-md-9 col-sm-12 col-xs-12" style="font-weight: normal;">
                                                                        {{ $observation->comment }}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="modal-footer">
                                                <ul class="list-inline">
                                                    @if($task->status_id == 1 && Auth::user()->role_id != 4)
                                                        <li>
                                                            {{-- Edit Task --}}
                                                            @if($task->status_id != 5)
                                                                <button type="button" class="btn btndefault" data-toggle="modal" role="button" data-target="#editTaskModal-{{ $task->id }}" title="Eliminar" data-dismiss="modal">
                                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                                </button>
                                                            @endif
                                                        </li>
                                                        <li>
                                                            {{-- Delete Task --}}
                                                            <button type="button" class="btn btndefault" data-toggle="modal" role="button" data-target="#removeTaskModal-{{ $task->id }}" title="Eliminar" data-dismiss="modal">
                                                                <span class="glyphicon glyphicon-remove-sign"></span> Borrar
                                                            </button>
                                                        </li>
                                                    @endif

                                                    {{-- Approve Task (If the user it's a project leader) --}}
                                                    @if(Auth::user()->role_id == 2)
                                                        <li>
                                                            {{-- Approved Task --}}
                                                            @if($task->status_id == 1)
                                                                <button type="button" class="btn btn-info" data-toggle="modal" role="button" data-target="#approveTaskModal-{{ $task->id }}" title="Aprobar Tarea" data-dismiss="modal">
                                                                    <span class="glyphicon glyphicon-ok-circle"></span> Aprobar
                                                                </button>
                                                            @endif
                                                        </li>
                                                    @else
                                                        <li>
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                                <i class="glyphicon glyphicon-ok-sign"></i> Ok
                                                            </button>
                                                        </li>
                                                    @endif

                                                    {{-- Task To Confirm (Task ready! Waits for project leader confirmation) --}}
                                                    @if($task->status_id == 2 && Auth::user()->role_id != 4)
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" role="button" data-target="#taskToConfirmModal-{{ $task->id }}" title="Confirmar Tarea" data-dismiss="modal">
                                                            <span class="glyphicon glyphicon-ok-sign"></span> Confirmar Gestión
                                                        </button>
                                                    @endif

                                                    {{-- Task to Confirm/Reject (The project's leader most confirm or not the specific task) --}}
                                                    @if(Auth::user()->role_id == 2 && $task->status_id == 3)
                                                        <li>
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" role="button" data-target="#rejectTaskModal-{{ $task->id }}" title="Devolver Tarea" data-dismiss="modal">
                                                                <span class="glyphicon glyphicon-repeat"></span> Devolver
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="btn btn-success" data-toggle="modal" role="button" data-target="#confirmTaskModal-{{ $task->id }}" title="Confirmar Gestión" data-dismiss="modal">
                                                                <span class="glyphicon glyphicon-check"></span> Confirmar
                                                            </button>
                                                        </li>
                                                    @endif

                                                    {{-- Task Rejected --}}
                                                    @if($task->status_id == 4 && Auth::user()->role_id != 4)
                                                        <button type="button" class="btn btn-warning" data-toggle="modal" role="button" data-target="#rejectedTaskModal-{{ $task->id }}" title="Confirmar Corrección" data-dismiss="modal">
                                                            <span class="glyphicon glyphicon-repeat"></span> Confirmar Corrección
                                                        </button>
                                                    @endif

                                                    {{-- Task Confirmed --}}
                                                    @if($task->status_id == 5 && Auth::user()->role_id == 2)
                                                        <button type="button" class="btn btn-default" data-toggle="modal" role="button" data-target="#reactivateTaskModal-{{ $task->id }}" title="Reactivar Tarea" data-dismiss="modal">
                                                            <span class="glyphicon glyphicon-refresh"></span> Reactivar
                                                        </button>
                                                    @endif

                                                    @if($task->status_id == 5 && Auth::user()->role_id == 4 && count($task->observations) % 2 == 0)
                                                        <button type="button" class="btn btn-success" data-toggle="modal" role="button" data-target="#observationTaskModal-{{ $task->id }}" title="Comentar Tarea" data-dismiss="modal">
                                                            <span class="glyphicon glyphicon-comment"></span> Comentar
                                                        </button>
                                                    @else
                                                        @if(Auth::user()->role_id == 2 && count($task->observations) > 0 && count($task->observations) % 2 != 0)
                                                            <button type="button" class="btn btn-warning" data-toggle="modal" role="button" data-target="#observationTaskModal-{{ $task->id }}" title="Comentar Tarea" data-dismiss="modal">
                                                                <span class="glyphicon glyphicon-comment"></span> Responder
                                                            </button>
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                {{-- Edit Task Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="editTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog modal-lg" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Editar Tarea</h4>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::model($task, ['route' => ['task.update', $project->id, $sprint->id, $task->id], 'data-parsley-validate' => '']) !!}
                                                    {{ csrf_field() }}
                                                    {{ Form::hidden('_method', 'PUT') }}

                                                    <div class="row">
                                                        @if($task->status_id == 1 || Auth::user()->role_id == 2)
                                                            <div class="col-md-9 col-sm-9">
                                                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => '']) }}
                                                                    @if ($errors->has('name'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('name') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            @php
                                                                $hours_left = $sprint->hours - $task_total_hours;
                                                                $hours_for_tasks = [1,2,3,5,8,13];
                                                                $hours_available = [];
                                                                foreach($hours_for_tasks as $hour ){
                                                                    if ($task->hours <= $hours_left) {
                                                                        if ($hour <= $hours_left) {
                                                                            $hours_available[$hour] = $hour;
                                                                        }
                                                                    }else {
                                                                        if ($hour <= $task->hours) {
                                                                            $hours_available[$hour] = $hour;
                                                                        }
                                                                    }
                                                                }
                                                            @endphp

                                                            <div class="col-md-3 col-sm-3">
                                                                <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                                                                    <div class="input-group">
                                                                        {{ Form::select('hours', $hours_available, $task->hours, ['id' => 'hours', 'class' => 'form-control']) }}
                                                                        <span class="input-group-addon" id='hours'><span class="glyphicon glyphicon-time"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-9 col-sm-9">
                                                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                    <div class="input-group">
                                                                        {{ Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                                                                        <span class="input-group-addon" id='name'><span class="glyphicon glyphicon-tag"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3">
                                                                <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                                                                    <div class="input-group">
                                                                        {{ Form::number('hours', null, ['id' => 'hours', 'class' => 'form-control', 'disabled' => 'disabled']) }}
                                                                        <span class="input-group-addon" id='hours'><span class="glyphicon glyphicon-time"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                        {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Información adicional...']) }}
                                                    </div>

                                                    <ul class="list-inline text-right">
                                                        <li>
                                                            {{-- Delete Task --}}
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" role="button" data-target="#removeTaskModal-{{ $task->id }}" title="Borrar" data-dismiss="modal">
                                                                <span class="glyphicon glyphicon-remove-sign"></span> <span class="hidden-xs">Borrar</span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancelar">
                                                                <i class="glyphicon glyphicon-remove-circle"></i> <span class="hidden-xs">Cancelar</span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            @if (Auth::user()->role_id == 2)
                                                                {{ Form::hidden('editedByLeader', true) }}
                                                                {{ Form::hidden('status_id', 2) }}
                                                                <button type="submit" class="btn btn-info" title="Aprobar">
                                                                    <span class="glyphicon glyphicon-ok-circle"></span> <span class="hidden-xs">Aprobar</span>
                                                                </button>
                                                            @else
                                                                {{ Form::submit('Actualizar', ['class' => 'btn btn-primary']) }}
                                                            @endif
                                                        </li>
                                                    </ul>
                                                {{ Form::close() }}
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                {{-- Delete Task Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="removeTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Eliminar Tarea</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Seguro deseas eliminar la tarea <strong>{{ $task->name }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <ul class="list-inline">
                                                    <li>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            <i class="glyphicon glyphicon-remove-sign"></i> No
                                                        </button>
                                                    </li>

                                                    <li>
                                                        {{ Form::open(['route' => ['task.destroy', $project->id, $sprint->id, $task->id]]) }}
                                                            {{ Form::hidden('_method', 'DELETE') }}
                                                            {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                                                        {{ Form::close() }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </td>
                            <td class="text-right task-table-text">{{ $task->hours }} {{ $task->hours > 1 ? "horas" : "hora" }}</td>
                            <td>
                                {{-- Approve Task Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="approveTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">{{ $task->name }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Confirmas la aprobación de la tarea?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <ul class="list-inline">
                                                    <li>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            <i class="glyphicon glyphicon-remove-sign"></i> No
                                                        </button>
                                                    </li>

                                                    <li>
                                                        {{ Form::open(['route' => ['task.update', $project->id, $sprint->id, $task->id]]) }}
                                                            {{ Form::hidden('_method', 'PUT') }}
                                                            {{ Form::hidden('changing_status', true) }}
                                                            {{ Form::hidden('status_id', 2) }}
                                                            {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-info']) }}
                                                        {{ Form::close() }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                {{-- Task to Confirm Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="taskToConfirmModal-{{ $task->id }}">
                                    <div class="modal-dialog" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">{{ $task->name }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Confirmas la gestión de la tarea?</p>
                                                {{ Form::open(['route' => ['task.update', $project->id, $sprint->id, $task->id]]) }}
                                                    <div class="form-group">
                                                        {{ Form::textarea('observation', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Observación (Opcional)']) }}
                                                    </div>

                                                <ul class="list-inline text-right">
                                                    <li>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            <i class="glyphicon glyphicon-remove-sign"></i> No
                                                        </button>
                                                    </li>

                                                    <li>
                                                        {{ Form::hidden('_method', 'PUT') }}
                                                        {{ Form::hidden('changing_status', true) }}
                                                        {{ Form::hidden('status_id', 3) }}
                                                        {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                                        {{ Form::close() }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                {{-- Task Reject Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="rejectTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">{{ $task->name }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Confirmas la devolución de la tarea?</p>
                                                {{ Form::open(['route' => ['task.update', $project->id, $sprint->id, $task->id], 'data-parsley-validate' => '']) }}
                                                    <div class="form-group">
                                                        {{ Form::textarea('observation', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Observación (Requerida)', 'required' => '']) }}
                                                    </div>

                                                    <ul class="list-inline text-right">
                                                        <li>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                <i class="glyphicon glyphicon-remove-sign"></i> No
                                                            </button>
                                                        </li>

                                                        <li>
                                                            {{ Form::hidden('_method', 'PUT') }}
                                                            {{ Form::hidden('changing_status', true) }}
                                                            {{ Form::hidden('status_id', 4) }}
                                                            {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                                                            {{ Form::close() }}
                                                        </li>
                                                    </ul>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                {{-- Task Confirm Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="confirmTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">{{ $task->name }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Confirmas que la gestión de la tarea se realizó de forma completa?</p>
                                                {{ Form::open(['route' => ['task.update', $project->id, $sprint->id, $task->id]]) }}
                                                    <div class="form-group">
                                                        {{ Form::textarea('observation', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Observación (Opcional)']) }}
                                                    </div>

                                                    <ul class="list-inline text-right">
                                                        <li>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                <i class="glyphicon glyphicon-remove-sign"></i> No
                                                            </button>
                                                        </li>

                                                        <li>
                                                            {{ Form::hidden('_method', 'PUT') }}
                                                            {{ Form::hidden('changing_status', true) }}
                                                            {{ Form::hidden('status_id', 5) }}
                                                            {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-success']) }}
                                                            {{ Form::close() }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                {{-- Task Reject Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="rejectedTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Tarea Corregida</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Confirmas la correción de la tarea <strong>{{ $task->name }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <ul class="list-inline">
                                                    <li>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            <i class="glyphicon glyphicon-remove-sign"></i> No
                                                        </button>
                                                    </li>

                                                    <li>
                                                        {{ Form::open(['route' => ['task.update', $project->id, $sprint->id, $task->id]]) }}
                                                            {{ Form::hidden('_method', 'PUT') }}
                                                            {{ Form::hidden('changing_status', true) }}
                                                            {{ Form::hidden('status_id', 3) }}
                                                            {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-warning']) }}
                                                        {{ Form::close() }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                {{-- Task Reject Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="reactivateTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">{{ $task->name }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Deseas reactivar la tarea?</p>
                                                {{ Form::open(['route' => ['task.update', $project->id, $sprint->id, $task->id]]) }}
                                                <div class="form-group">
                                                    {{ Form::textarea('observation', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Observación (Requerido)', 'required' => '']) }}
                                                </div>
                                                <ul class="list-inline text-right">
                                                    <li>
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">
                                                            <i class="glyphicon glyphicon-remove-sign"></i> No
                                                        </button>
                                                    </li>

                                                    <li>
                                                        {{ Form::hidden('_method', 'PUT') }}
                                                        {{ Form::hidden('changing_status', true) }}
                                                        {{ Form::hidden('status_id', 6) }}
                                                        {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-default']) }}
                                                        {{ Form::close() }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                {{-- Observation Task Modal --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="observationTaskModal-{{ $task->id }}">
                                    <div class="modal-dialog" role="dialog" id="model-{{ $task->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title"><span class="glyphicon glyphicon-send"></span> Notas</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="well">
                                                    <strong>Tarea:</strong> {{ $task->name }}
                                                </div>
                                                {{ Form::open(['route' => ['observation.store', $project->id, $sprint->id, $task->id], 'data-parsley-validate' => '']) }}
                                                <div class="form-group">
                                                    {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Ingrese alguna observación acá...', 'required' => '', 'minlenght' => 5, 'maxlength' => 2000]) }}
                                                </div>
                                                <ul class="list-inline text-right">
                                                    <li>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
                                                        </button>
                                                    </li>

                                                    <li>
                                                        {{ Form::hidden('user_id', Auth::user()->id) }}
                                                        {{ Form::button('<i class="glyphicon glyphicon-send"></i> Comentar', ['type' => 'submit', 'class' => 'btn btn-success']) }}
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
            {{ $tasks->links() }}
        </div>

        {{-- Client View --}}

        {{--  <div class="list-group">
            @foreach($tasks as $task)
                @php
                    switch ($task->status->id) {
                        case 1:
                            $_class = 'default';
                            break;
                        case 2:
                            $_class = 'info';
                            break;
                        case 3:
                            $_class = 'warning';
                            break;
                        case 4:
                            $_class = 'danger';
                            break;
                        case 5:
                            $_class = 'success';
                            break;
                        default:
                            $_class = 'default';
                            break;
                    }
                @endphp

                <a href="{{ route('task.show', [$project->id, $sprint->id, $task->id]) }}" class="list-group-item list-group-item-{{ $_class }}">
                    <span class="glyphicon glyphicon-erase"></span> {{ $task->name }}
                    <span class="glyphicon glyphicon-new-window pull-right" title="Abrir Tarea"></span>
                </a>
            @endforeach
        </div>
        <div class="text-center">
            {{ $tasks->links() }}
        </div>
    @endif  --}}
    @else
        {{--  <div class="alert alert-warning">
            <span class="glyphicon glyphicon-info-sign"></span> No se han registrado tareas para el Sprint.
        </div>  --}}
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
        <div class="modal-dialog" role="document">
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
                        <button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#collapseToConfirm" aria-expanded="false" aria-controls="collapseToConfirm">En Revisión</button>
                        <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#collapseRejected" aria-expanded="false" aria-controls="collapseRejected">Devuelta</button>
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
                                <span class="text-warning"><span class="glyphicon glyphicon-ok-sign"></span> {{ $statuses[3] }}</span>
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

    {{-- Sprint Information Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="sprintDescriptionModal">
        <div class="modal-dialog" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        {{ $sprint->name }} | <small>{{ $sprint->hours }} horas</small>
                    </h4>
                </div>

                <div class="modal-body">
                    {!! $sprint->description !!}

                    @if ($sprint->start_on != null || $sprint->ends_on != null)
                        <div class="row list-group">
                            <div class="col-md-4 col-md-offset-8 col-sm-6 col-sm-offset-6 text-center">
                                <div class="list-group-item">
                                    <span class="glyphicon glyphicon-calendar text-success"></span> <span class="text-success date-font-size"> Inicia: {{ $sprint->starts_on->format('d/m/Y') }}</span>
                                </div>
                                <div class="list-group-item">
                                    <span class="glyphicon glyphicon-calendar text-danger"></span> <span class="text-danger date-font-size"> Cierra: {{ $sprint->ends_on->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <ul class="list-inline">
                        @if(Auth::user()->role_id != 4)
                            <li>
                                <a type="button" href="{{ route('sprint.edit', [$project->id, $sprint->id]) }}" class="btn btn-default" title="Editar">
                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                </a>
                            </li>
                            <li>
                                <a type="button" class="btn btn-default" type="button" data-toggle="modal" data-target="#confirmationModal" title="Eliminar" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remove-circle"></span> Eliminar
                                </a>
                            </li>
                        @endif
                        <li>
                            <a type="button" class="btn btn-primary" data-dismiss="modal">
                                <i class="glyphicon glyphicon-ok-sign"></i> Ok
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('scripts')
    {!! Html::script('js/parsley.js') !!}
@endsection