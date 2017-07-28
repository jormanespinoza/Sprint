@extends('layouts.app')

@section('title', '| Escritorio')

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}"><span class="glyphicon glyphicon-folder-close"></span> Proyectos</a>
        </li>
    </ol>

    <h5><span class="glyphicon glyphicon-folder-close"> </span> Tus Proyectos</h5>
    <hr>
    @if(count(Auth::user()->projects) > 0) 
        @foreach($user->projects as $project)
            @foreach($project->sprints as $sprint)
                @php
                    $all_sprints_done = true;
                    if (!$sprint->done) {
                        $all_sprints_done = false;
                    }
                @endphp
            @endforeach
            <a href="{{ route('project.show', $project->id) }}" class="list-group-item list-group-item-{{ $all_sprints_done ? "success " : "action"}}">
                <span class="glyphicon glyphicon-file"></span> {{ $project->name }}
                <span class="glyphicon glyphicon-folder-open pull-right" title="Abrir Proyecto"></span>
            </a>
        @endforeach
    @else
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-info-sign"></span> No tienes proyectos asignados.
        </div>
    @endif
        
@endsection