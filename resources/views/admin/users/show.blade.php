@extends('layouts.app')

@section('title', '| Usuario: ' . $user->first_name)

@section('content')
    <div class="row">
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
                {{--  <div class="col-md-8">
                    <div class="panel">
                        <div class="panel-heading">Información de Perfil</div>
                            <div class="panel-body">
                            
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima non laborum eum accusantium blanditiis sapiente ratione provident. Officia dolorem eligendi maxime praesentium doloremque voluptatibus vel, repellendus at, rerum voluptates aperiam!
                            </div>
                        </div>
                    </div>
                </div>  --}}
                <div class="col-md-8 col-md-offset-4">
                    <div class="show-actions-btn text-right">
                        <a href="{{ route('users.edit', $user->id) }}" class="well text-center">
                            <span class="glyphicon glyphicon-edit"></span> Editar
                        </a>

                        @if (Auth::user()->id != $user->id)
                            <a href="" class="well text-center" type="button" data-toggle="modal" data-target="#confirmationModal" title="Eliminar">
                                <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">3D Sprint - Confirmación</h4>
                </div>
                <div class="modal-body">
                    <p>¿Seguro deseas eliminar este usuario?</p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </li>

                        <li>
                            {{ Form::open(['route' => ['users.destroy', $user->id]]) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::submit('Sí', ['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection