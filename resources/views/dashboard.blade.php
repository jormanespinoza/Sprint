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
            <a href="{{ route('project.show', $project->id) }}" class="list-group-item list-group-item-action">
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