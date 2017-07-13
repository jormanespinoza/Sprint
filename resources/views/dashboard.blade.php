@extends('layouts.app')

@section('title', '| Escritorio')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if(Auth::user()->role_id === 1)
                        Panel de Administración
                    @else
                        Proyectos
                    @endif
                </div>

                <div class="panel-body">
                    @if(Auth::user()->role_id === 1)
                        Ingresaste como {{ $role }} | Nivel de Usuario: {{ Auth::user()->role_id }}
                    @endif
                    @if(Auth::user()->role_id === 2)
                        Ingresaste como {{ $role }} | Nivel de Usuario: {{ Auth::user()->role_id }}
                    @endif
                    @if(Auth::user()->role_id === 3)
                         Ingresaste como {{ $role }} | Nivel de Usuario: {{ Auth::user()->role_id }}
                     @endif
                     @if(Auth::user()->role_id === 4)
                        Ingresaste como {{ $role }} | Nivel de Usuario: {{ Auth::user()->role_id }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
