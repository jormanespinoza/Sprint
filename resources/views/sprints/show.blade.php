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
            <span>{{ $sprint->name }}</span>
        </div>
    </div>

    
    <div class="well" title="Descripción del Proyecto">
        {!! $sprint->description !!}
    </div>

    <h5><span class="glyphicon glyphicon-tasks"></span> Tareas <a href="" class="btn btn-sm btn-primary pull-right">Añadir Nueva Tarea</a></h5>
    <hr>

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
@endsection