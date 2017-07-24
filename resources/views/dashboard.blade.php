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
        <table class="table table-hover">
            <thead>
                <th style="min-width: 200px;">Nombre</th>
                <th>Descripción</th>
                <th></th>
            </thead>

            <tbody>
                @foreach(Auth::user()->projects as $project)
                    <tr>
                        <td class="list-name">{{ $project->name }}</td>
                        <td>
                            {{ substr(strip_tags($project->description), 0, 110) }} {{ strlen(strip_tags($project->description)) > 110 ? '...' : '' }}
                        </td>
                        <th>
                            <a href="{{ route('project.show', $project->id) }}" class="btn btn-xs btn-default">
                                <span class="glyphicon glyphicon-folder-open"></span>
                            </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-info-sign"></span> No tienes proyectos asignados.
        </div>
    @endif
        
@endsection