@extends('layouts.app')

@section('title', '| Registro de Usuario')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="text-left">
                <h1 class="app-title"> <img src="{{ url('images/logo.png')}}" alt="Logo de 3D Sprint">{{ config('app.name', 'Laravel') }}
                    <small>
                        Gestión de Proyectos 
                        <a type="button" data-toggle="modal" data-target="#informationModal" title="Información de la Aplicación">
                            <small><span class="glyphicon glyphicon-info-sign"></span></small>
                        </a>
                    </small>
                </h1>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-list-alt"></span> Registro</div>
            </div>

            <form class="form-horizontal" method="POST" action="{{ route('register') }}" novalidate>
                {{ csrf_field() }}

                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="col-md-4 control-label">Nombre</label>

                        <div class="col-md-8">
                            <div class="input-group">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                <span class="input-group-addon" id="first_name"><span class="glyphicon glyphicon-tag"></span></span>
                            </div>

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="col-md-4 control-label">Apellido</label>

                        <div class="col-md-8">
                            <div class="input-group">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                                <span class="input-group-addon" id="last_name"><span class="glyphicon glyphicon-tags"></span></span>
                            </div>

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">Correo Electrónico</label>

                        <div class="col-md-8">
                            <div class="input-group">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                <span class="input-group-addon" id="email"><span class="glyphicon glyphicon-envelope"></span></span>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                        <label for="role_id" class="col-md-4 control-label">Rol</label>

                        <div class="col-md-8">
                            <div class="input-group">
                                {{ Form::select('role_id', $roles, null, ['class' => 'form-control']) }}
                                <span class="input-group-addon" id="role_id"><span class="glyphicon glyphicon-list-alt"></span></span>
                            </div>

                            @if ($errors->has('role_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('role_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Contraseña</label>

                        <div class="col-md-8">
                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="password" required>
                                <span class="input-group-addon" id="password"><span class="glyphicon glyphicon-lock"></span></span>
                            </div>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                        <div class="col-md-8">
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                <span class="input-group-addon" id="password"><span class="glyphicon glyphicon-repeat"></span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-block btn-primary">
                            Enviar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Information Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="informationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">3D Sprint</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Aplicación desarrollada por el equipo de <a href="http//3dlinkweb.com" target="_blank">3D Link</a>, encargada de la gestión de los proyectos de cada uno de los desarrolladores de la empresa.
                    </p>
                    <p>
                        Cada cliente podrá acceder a sus respectivos proyectos, observar las tareas pendientes, fechas, tiempo estimado de las actividades, enviar mensajes y observaciones referentes a cada una de las etapas.
                    </p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                                <i class="glyphicon glyphicon-ok-sign"></i> Perfecto
                            </button>
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection