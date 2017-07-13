@extends('layouts.app')

@section('title', '| Editar Usuario')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
            <div class="panel-heading">Crear Usuario</div>
                <div class="panel-body">
                    {!! Form::model($user, ['route' => ['users.update', $user->id], 'class' => 'form-horizontal', 'novalidate' => '']) !!}
                        {{ csrf_field() }}
                        {{ Form::hidden('_method', 'PUT') }}
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            {{ Form::label('first_name', 'Nombre', ['class' => 'col-md-4 control-label', 'for' => 'first_name'])}}
                            <div class="col-md-6">
                                {{ Form::text('first_name', null, ['class' => 'form-control', 'for' => 'first_name', 'required' => '']) }}
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            {{ Form::label('last_name', 'Apellido', ['class' => 'col-md-4 control-label', 'for' => 'last_name'])}}
                            <div class="col-md-6">
                                {{ Form::text('last_name', null, ['class' => 'form-control', 'for' => 'last_name', 'required' => '']) }}

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', 'Correo Electrónico', ['class' => 'col-md-4 control-label', 'for' => 'email'])}}
                            <div class="col-md-6">
                                {{ Form::email('email', $user->email, ['class' => 'form-control', 'disabled' => 'disabled']) }}

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                            {{ Form::label('role_id', 'Nivel de Acceso', ['class' => 'col-md-4 control-label', 'for' => 'role_id']) }}
                            <div class="col-md-6">
                                @if (Auth::user()->id == $user->id)
                                    {{ Form::select('role_id', ['1' => 'Administrador'], null, ['class' => 'form-control']) }}
                                @else
                                    {{ Form::select('role_id', $roles, null, ['class' => 'form-control']) }}
                                @endif

                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit('Registrar', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection