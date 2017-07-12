@extends('layouts.app')

@section('title', 'Usuario: ' . $user->first_name)

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
            <p>{{ $user->email }}</p>
            <p>{{ $user->role->name }}</p> 
        </div>
    </div>
@endsection