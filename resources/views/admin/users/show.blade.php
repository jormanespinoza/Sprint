@extends('layouts.admin')

@section('title', '| Usuario: ' . $user->first_name)

@section('data')
    <ol class="breadcrumb">
        @include('partials._toggle_menu')
        <li>
            <a href="{{ url('admin') }}"><span class="glyphicon glyphicon-th-large"></span> Inicio</a>
        </li>
        <li>
            <a href="{{ url('admin/users') }}"><span class="glyphicon glyphicon-user"></span> Usuarios</a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-tag"></span> {{ $user->first_name }}
        </li>
    </ol>

    <div class="col-md-4">
        <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->email))) . "?d=retro" }}" class="img-responsive img-circle" alt="Avatar">
        <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
        <p>{{ $user->email }}</p>
            @php
                # check the user role to assing a specific class to it
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
        <p>
            <span class="label {{ $label_class }}"><strong>{{ $user->role->name }}</strong></span>
        </p> 
    </div>

    <div class="col-md-8">
        <div class="panel-body">
            Bio...
        </div>
    </div>

    <div class="clearfix"></div>

    @if($user->role_id != 1)
        <div class="col-md-12">
            <h5>
                <span class="glyphicon glyphicon-folder-close"></span> Projectos Asignados
            </h5>
            <hr>
            <div class="list-group">
                @if(count($user->projects) > 0)
                    @foreach($user->projects as $project)
                        <a href="{{ route('projects.show', $project->id) }}" class="list-group-item list-group-item-action">
                            <strong><span class="glyphicon glyphicon-file"></span> {{ $project->name }}</strong>
                            <span class="glyphicon glyphicon-folder-open pull-right" title="Abrir Proyecto"></span>
                        </a>
                    @endforeach
                @else
                    <p class="list-group-item list-group-item-action text-warning">
                        <strong><span class="glyphicon glyphicon-alert"></span> No se encuentran proyectos asignados.</strong>
                    </p>
                @endif
            </div>
        </div>
    @endif

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

    {{-- Confirmation Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <p>¿Seguro deseas eliminar este usuario?</p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="glyphicon glyphicon-remove-sign"></i> No
                            </button>
                        </li>
                        <li>
                            {{ Form::open(['route' => ['users.destroy', $user->id]]) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection