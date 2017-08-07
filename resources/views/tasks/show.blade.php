@extends('layouts.app')

@section('title', '| ' . $task->name)

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
                <span class="glyphicon glyphicon-inbox"></span> Sprints
            </a>
        </li>
        <li>
            <a href="{{ route('sprint.show', [$project->id, $sprint->id]) }}">
                <span class="glyphicon glyphicon-inbox"></span> {{ $sprint->name }}
            </a>
        </li>
        <li classs="active">
            <span class="glyphicon glyphicon-erase"></span> {{ $task->name }}
        </li>
    </ol>
    <h5>
        <span class="glyphicon glyphicon-erase"></span> {{ $task->name}} 
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
         | <span class="label label-{{ $_class }}"><strong>{{ $task->status->name }}</strong></span>
    </h5>

    @if ($task->description != null)
        <div class="well">
            {!! $task->description!!}
        </div>
    @endif

    <div class="row list-group">
        <div class="col-md-3 col-md-offset-9 col-sm-5 col-sm-offset-7 text-center">
            <div class="list-group-item">
                Número de Horas <span class="badge">{{ $task->hours }}
            </div> 
        </div>
    </div>

    @if(count($task->observations) > 0)
        <span class="glyphicon glyphicon-send"></span> Notas
        <hr>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @foreach($task->observations as $observation)
                    <div class="row task-comments">
                        <div class="col-md-1">
                            <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($observation->user->email))) . "?d=retro" }}" class="img-circle user-observation" alt="Avatar">
                        </div>

                        <div class="col-md-2">
                            {{ $observation->user->first_name }}<br>
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

                        <div class="col-md-9">
                            <blockquote class="task-comment">
                                {{ $observation->comment }}
                            </blockquote>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="list-inline text-right">
        <br>
        @if($task->status_id == 5 && Auth::user()->role_id == 4 && count($task->observations) % 2 == 0)
            <li>
                <button type="button" class="btn btn-success" data-toggle="modal" role="button" data-target="#observationTaskModal-{{ $task->id }}" title="Comentar Tarea" data-dismiss="modal">
                    <span class="glyphicon glyphicon-comment"></span> Comentar
                </button>
            </li>
        @else
            @if(Auth::user()->role_id == 2 && count($task->observations) > 0 && count($task->observations) % 2 != 0)
                <li>
                    <button type="button" class="btn btn-warning" data-toggle="modal" role="button" data-target="#observationTaskModal-{{ $task->id }}" title="Comentar Tarea" data-dismiss="modal">
                        <span class="glyphicon glyphicon-comment"></span> Responder
                    </button>
                </li>
            @endif
        @endif
        <li>
            <a href="{{ route('sprint.show', [$project->id, $task->sprint->id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-tasks"></span> Volver al Sprint</a>
        </li>
    </div>

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
@endsection

@section('scripts')
    {!! Html::script('js/parsley.js') !!}
@endsection