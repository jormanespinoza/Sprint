@extends('partials._head')

<div class="text-left">
    <a href="{{ config('app.url') }}" style="text-decoration: none;">
        <h2 class="app-title"> <img src="{{ url('images/logo.png')}}" alt="Logo de 3D Sprint">{{ config('app.name', 'Laravel') }}
            <small>
                | Gestión de Proyectos 
            </small>
        </h2>
    </a>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="text-center ">
            {!! $bodyMessage !!}
        </div>
    </div>
</div>