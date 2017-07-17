@extends('layouts.admin')

@section('title', '| Listado de Usuarios')

@section('data')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('admin') }}"><span class="glyphicon glyphicon-th-large"></span> Inicio</a>
        </li>
        <li class="active"><span class="glyphicon glyphicon-user"></span> Usuarios</a></li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8 col-xs-8">
                    <div class="heading-title">
                        Listado de Usuarios | <span class="label label-primary">Total {{ count($users) }} </span>
                    </div>
                </div>
                <div class="col-md-4 col-xs-4">
                    <span class="pull-right">
                        <a href="{{ Route('users.create') }}" class="btn btn-sm btn-primary" title="Crear Usuario">
                            <span class="glyphicon glyphicon-user"></span> Nuevo
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Nivel</th>
                        <th class="actions">Acciones</th>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th>{{ $user->id }}</th>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
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
                                    <span class="label {{ $label_class }}"><b>{{ $user->role->name }}</b></span>
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-xs btn-default" title="Ver"><span class="glyphicon glyphicon-zoom-in"></span></a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-warning" title="Editar"><span class="glyphicon glyphicon-edit"></span></a>

                                    @if(Auth::user()->id == $user->id)
                                        <button type="button" class="btn btn-xs btn-danger" title="Acción Deshabilitada" disabled>
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" role="button" data-target="#confirmationModal-{{ $user->id }}" title="Eliminar">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                        </button>
                                    @endif

                                    {{-- Confirmation Modal --}}
                                    <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal-{{ $user->id }}">
                                        <div class="modal-dialog" role="dialog" id="model-{{ $user->id }}">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">3D Sprint - Confirmación</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Seguro deseas eliminar el usuario de <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>?</p>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $users->links( )}}
            </div>
        </div>
    </div>
    
@endsection