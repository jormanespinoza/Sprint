@extends('layouts.admin')

@section('title', '| Crear Usuario')

@section('data')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('admin') }}"><span class="glyphicon glyphicon-th-large"></span> Inicio</a>
        </li>
        <li>
            <a href="{{ url('admin/users') }}"><span class="glyphicon glyphicon-user"></span> Usuarios</a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-log-in"></span> Nuevo Usuario
        </li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">Crear Usuario</div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{route('users.store') }}" novalidate>
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label for="first_name" class="col-md-4 control-label">Nombre</label>

                    <div class="col-md-6">
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

                    <div class="col-md-6">
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

                    <div class="col-md-6">
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

                <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                    <label for="role_id" class="col-md-4 control-label">Nivel</label>

                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="role_id" type="" class="form-control" name="role_id" value="{{ old('role_id') }}" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
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

                    <div class="col-md-6">
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

                    <div class="col-md-6">
                        <div class="input-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            <span class="input-group-addon" id="password"><span class="glyphicon glyphicon-repeat"></span></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-block btn-primary">
                            Registrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection