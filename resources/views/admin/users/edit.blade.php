@extends('layouts.admin')

@section('title', '| Editar Usuario')

@section('stylesheets')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('data')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('admin') }}">
                <span class="glyphicon glyphicon-dashboard"></span> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ url('admin/users') }}"><span class="glyphicon glyphicon-user"></span> Usuarios</a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-edit"></span> Editar Usuario
        </li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> Información General</div>
        <div class="panel-body">
            {!! Form::model($user, ['route' => ['users.update', $user->id], 'class' => 'form-horizontal', 'novalidate' => '']) !!}
                {{ csrf_field() }}
                {{ Form::hidden('_method', 'PUT') }}

                <div class="col col-md-6">
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        {{ Form::label('first_name', 'Nombre', ['class' => 'control-label', 'for' => 'phone'])}}
                        <div class="input-group">
                            {{ Form::text('first_name', $user->first_name, ['class' => 'form-control', 'for' => 'phone', 'required' => '']) }}
                            <span class="input-group-addon" id='first_name'><span class="glyphicon glyphicon-tag"></span></span>
                        </div>
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        {{ Form::label('last_name', 'Apellido', ['class' => 'control-label', 'for' => 'last_name'])}}
                        <div class="input-group">
                            {{ Form::text('last_name', $user->last_name, ['class' => 'form-control', 'for' => 'last_name', 'required' => '']) }}
                            <span class="input-group-addon" id="last_name"><span class="glyphicon glyphicon-tags"></span></span>
                        </div>

                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {{ Form::label('email', 'Correo Electrónico', ['class' => 'control-label', 'for' => 'email'])}}
                        <div class="input-group">
                            {{ Form::email('email', $user->email, ['class' => 'form-control']) }}
                                <span class="input-group-addon" id="email"><span class="glyphicon glyphicon-envelope"></span></span>
                        </div>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                        {{ Form::label('role_id', 'Tipo de Usuario', ['class' => 'control-label', 'for' => 'role_id']) }}
                        <div class="input-group">
                            @if (Auth::user()->id == $user->id)
                                {{ Form::select('role_id', ['1' => 'Administrador'], null, ['class' => 'form-control']) }}
                            @else
                                {{ Form::select('role_id', $roles, null, ['class' => 'form-control']) }}
                            @endif
                            <span class="input-group-addon" id="role_id"><span class="glyphicon glyphicon-list-alt"></span></span>
                        </div>

                        @if ($errors->has('role_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::submit('Actualizar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-pencil"></span> Información Personal</div>
        <div class="panel-body">
            {!! Form::model($profile, ['route' => ['profile.update', $user->id], 'class' => 'form-horizontal', 'novalidate' => '']) !!}
                {{ csrf_field() }}
                {{ Form::hidden('_method', 'PUT') }}

                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        {{ Form::label('phone', 'Teléfono', ['class' => 'control-label', 'for' => 'phone'])}}
                        <div class="input-group">
                            {{ Form::text('phone', null, ['class' => 'form-control', 'for' => 'phone', 'placeholder' => '+584120000000']) }}
                            <span class="input-group-addon" id='phone'><span class="glyphicon glyphicon-phone"></span></span>
                        </div>
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label name="bio" class="control-label" for="phone">Biografía</label>
                        {!! Form::textarea('bio', null, ['class' => 'form-control', 'id' => 'bio', 'for' => 'bio', 'name' => 'bio'])!!}
                        @if ($errors->has('bio'))
                            <span class="help-block">
                                <strong>{{ $errors->first('bio') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Actualizar', ['class' => 'btn btn-block btn-info']) }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
    {!! Html::script('plugins/trumbowyg/trumbowyg.js') !!}
    {!! Html::script('plugins/trumbowyg/langs/es.min.js') !!}
    <script>
        $('textarea').trumbowyg({
            lang: 'es'
        });
    </script>
@endsection
