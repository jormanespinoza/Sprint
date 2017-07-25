@extends('layouts.app')

@section('title', '| Crear Tarea')

@section('content')
    <h5><span class="glyphicon glyphicon-save-file"></span> Crear Nueva Tarea</h5>
    <hr>
    <div class="col-md-12">
        {{ Form::open(['route' => ['task.store', $project->id, $sprint->id]]) }}
            {{ csrf_field() }}
            {{ Form::submit('Crear', ['class' => 'btn btn-block btn-default']) }}
        {{ Form::close() }}
    </div>
@endsection