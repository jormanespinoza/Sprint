@extends('layouts.app')

@section('title', 'Usuario: ' . $user->first_name)

@section('content')
    <div class="row panel">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->email))) . "?d=retro" }}" class="img-responsive img-circle" alt="Avatar">
                    <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
                    <p>{{ $user->email }}</p>
                        @php 
                            switch ($user->role->id) {
                                case 1:
                                    $label_class = 'label-success';
                                    break;
                                case 2:
                                    $label_class = 'label-primary';
                                    break;
                                case 3:
                                    $label_class = 'label-info';
                                    break;
                                default:
                                    $label_class = 'label-default';
                                    break;
                            }
                        @endphp
                    <p><span class="label {{ $label_class }}">{{ $user->role->name }}</span></p> 
                </div>
                <div class="col-md-8">
                    <div class="panel">
                        <div class="panel-heading">Información de Perfil</div>
                            <div class="panel-body">
                            
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima non laborum eum accusantium blanditiis sapiente ratione provident. Officia dolorem eligendi maxime praesentium doloremque voluptatibus vel, repellendus at, rerum voluptates aperiam!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row nav">
        <div class="col-md-8 col-xs-8 col-xs-offset-2">
            <a href="{{ route('users.edit', $user->id) }}">
                <div class="col-md-5 col-xs-5 well text-center">
                    <span class="glyphicon glyphicon-edit"></span> Editar
                </div>
            </a>

            @if (Auth::user()->id != $user->id)
                <a href="{{ route('users.destroy', $user->id) }}" onclick="return confirm('¿Está seguro de que desea eliminar el usuario?')" title="Eliminar">
                    <div class="col-md-5 col-md-offset-1 col-xs-5 col-xs-offset-1 well text-center">
                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                    </div>
                </a>
            @endif
            
        </div>
    </div>
@endsection