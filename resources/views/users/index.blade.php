@extends('layouts.app')

@section('title', '| Listado de Usuarios')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10">
                        Listado de Usuarios
                    </div>
                    <div class="col-md-2">
                        <a href="{{ Route('users.create') }}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-pawn"></span> Crear Usuario</a>
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
                                <th>Acciones</th>
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
                                            <span class="label {{ $label_class }}">{{ $user->role->name }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-xs btn-default" title="Ver"><span class="glyphicon glyphicon-zoom-in"></span></a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-warning" title="Editar"><span class="glyphicon glyphicon-edit"></span></a>
                                            <a href="{{ route('users.destroy', $user->id) }}" onclick="return confirm('¿Está seguro de que desea eliminar el usuario?')" class="btn btn-xs btn-danger" title="Eliminar"><span class="glyphicon glyphicon-remove-sign"></span></a>
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
        </div>
    </div>
@endsection