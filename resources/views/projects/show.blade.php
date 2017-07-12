@extends('layouts.app')

@section('title', '| Proyecto: ' . $project->name);

@section('content')
    <h1>{{ $project->name }}</h1>
    <div class="well">{!! $project->description !!}</div>
    <p class="text-right">Creado {{ $project->created_at->diffForHumans() }}</p>
@endsection