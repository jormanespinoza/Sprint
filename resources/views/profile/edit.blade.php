@extends('layouts.app')

@section('title', '| Editar Perfil')

@section('stylesheets')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}"><span class="glyphicon glyphicon-folder-close"></span> Proyectos</a>
        </li>
        <li>
            <a href="{{ url('profile/' . $user->id) }}">
            <span class="glyphicon glyphicon-tag"></span> {{ $user->first_name }}</a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-edit"></span> Actualizar
        </li>
    </ol>

    <div class="col-md-4">
        <span>
            <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->email))) . "?d=retro" }}" class="img-responsive img-circle place" alt="Avatar">
            <a type="button" data-toggle="modal" data-target="#imageInfoModal" title="¿Cómo cambiar imagen?">
                <small><span class="glyphicon glyphicon-question-sign"></span></small>
            </a>
        </span>

        <h2 class="username">
            {{ $user->first_name }} {{ $user->last_name }}

            @if($user->profile->bio != null)
                <small>
                    <a type="button" data-toggle="modal" data-target="#userInfoModal" title="Información del Usuario">
                        <span class="glyphicon glyphicon-info-sign"></span>
                    </a>
                </small>
            @endif
        </h2>

        <p>
            <span class="glyphicon glyphicon-envelope"></span> {{ $user->email }}
        </p>

        @if($user->profile->phone != null)
            <p>
                <span class="glyphicon glyphicon-phone"></span> {{ $user->profile->phone }}
            </p>
        @else
            <p>
                <span class="glyphicon glyphicon-phone"></span> <span class="label label-default"> No asignado</span>
            </p>
        @endif

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
            <span class="glyphicon glyphicon-list-alt"></span> <span class="label {{ $label_class }}">
                <strong>{{ $user->role->name }}</strong>
            </span>
        </p>
    </div>

    <div class="col-md-8">
        {!! Form::model($user, ['route' => ['profile.update', $user->id], 'class' => 'form-horizontal', 'novalidate' => '']) !!}
            {{ csrf_field() }}
            {{ Form::hidden('_method', 'PUT') }}

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

            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                {{ Form::label('phone', 'Teléfono', ['class' => 'control-label', 'for' => 'phone'])}}
                <div class="input-group">
                    {{ Form::text('phone', $user->profile->phone, ['class' => 'form-control', 'for' => 'phone', 'placeholder' => '+584120000000']) }}
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
                {!! Form::textarea('bio', $user->profile->bio, ['class' => 'form-control', 'id' => 'bio', 'for' => 'bio', 'name' => 'bio'])!!}
                @if ($errors->has('bio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bio') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group text-right">
                {{ Form::submit('Actualizar', ['class' => 'btn btn-block btn-success']) }}
            </div>
        {{ Form::close() }}
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

    {{-- Image Information Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="imageInfoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Imagen de Perfil</h4>
                </div>
                <div class="modal-body">
                    <p>
                        La imagen de perfil esta directamente enlazada con la web de <a href="https://es.gravatar.com/" target="_blank">Gravatar</a>, la cual generá una imagen de perfil web globalmente reconocida en internet.
                    </p>
                    <p>
                        Para añadir una imagen, solo sigue estos tres sencillos pasos:
                        <ol>
                            <li>Registra un usuario con tu correo electrónico asociado a 3D Sprint, en la web de <a href="https://es.gravatar.com/" target_="blank">Gravatar</a>.</li>
                            <li>Confirma tu usuario, a través del enlace de confirmación que te fue enviado por email.</li>
                            <li>Sube la imagen que desees para tu perfil.</li>
                        </ol>
                    </p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                                <i class="glyphicon glyphicon-ok-sign"></i> Listo!
                            </button>
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- User Information Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="userInfoModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Información de {{ $user->first_name }}</h4>
                </div>
                <div class="modal-body">
                    {!! $user->profile->bio !!}
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                                <i class="glyphicon glyphicon-ok-sign"></i> Ok
                            </button>
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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