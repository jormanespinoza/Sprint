@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Escritorio</div>
                @if(Auth::user()->role_id === 1)
                    <div class="panel-body">
                         Ingresaste como Administrador | Nivel de Usuario: {{ Auth::user()->role_id }}
                    </div>
                @endif

                @if(Auth::user()->role_id === 2)
                    <div class="panel-body">
                         Ingresaste como Líder | Nivel de Usuario: {{ Auth::user()->role_id }}
                    </div>
                @endif

                @if(Auth::user()->role_id === 3)
                    <div class="panel-body">
                         Ingresaste como Desarrollador | Nivel de Usuario: {{ Auth::user()->role_id }}
                    </div>
                @endif

                @if(Auth::user()->role_id === 4)
                    <div class="panel-body">
                         Ingresaste como Cliente | Nivel de Usuario: {{ Auth::user()->role_id }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
