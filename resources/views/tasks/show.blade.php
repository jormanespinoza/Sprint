@extends('layouts.app')

@section('title', '| ' . $task->name)

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

    <div class="well">
        {!! $task->description!!}
    </div>

    <div class="row list-group">
        <div class="col-md-3 col-md-offset-9 col-sm-5 col-sm-offset-7 text-center">
            <div class="list-group-item">
                Número de Horas <span class="badge">{{ $task->hours }}
            </div> 
        </div>
    </div

    <h5><span class="glyphicon glyphicon-comment"></span> Observaciones</h5>
    <hr>
@endsection