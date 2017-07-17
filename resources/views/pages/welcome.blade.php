@extends('layouts.home')

@section('title', '| Inicio')

@section('content')
    <div class="jumbotron">
        <div class="container-fluid">
            <div class="{{ Auth::guest() ? 'col-md-8' : 'col-md-12' }} text-left">
                <h1> <img src="{{ url('images/logo.png')}}" alt="Logo de 3D Sprint">3D Sprint</h1>
                <p>
                    Aplicación desarrollada por el equipo de <a href="http//3dlinkweb.com" target="_blank">3D Link</a>, encargada de la gestión de los proyectos de cada uno de los desarrolladores de la empresa.
                </p>
                <p>
                    Cada cliente podrá acceder a sus respectivos proyectos, observar las tareas pendientes, fechas, tiempo estimado de las actividades, enviar mensajes y observaciones referentes a cada una de las etapas.
                </p>
            </div>
            @if(Auth::guest())
                <div class="col-md-4">
                    <!-- Sign In Form -->
                    @include('partials._messages')
                    <div class="panel panel-primary">
                        <div class="panel-heading text-center">Accede a 3D Sprint</div>
                        <div class="panel-body">
                            <form class="form" method="POST" action="{{ route('login') }}" novalidate>
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="email"><span class="glyphicon glyphicon-envelope"></span></span>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" aria-describedby="basic-addon1" required autofocus>
                                    </div>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Contraseña</label>
                                    <a class="pull-right" href="{{ route('password.request') }}">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="password"><span class="glyphicon glyphicon-lock"></span></span>
                                        <input id="password" type="password" class="form-control" name="password" required>
                                    </div>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuérdame
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    Ingregar
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            ¿Nuevo en 3D Sprint? | 
                            <a class="text-right" href="{{ route('register') }}" data-ga-click="Sign in, switch to sign up">Crea una cuenta</a>
                        </div>
                    </div>
                </div>
            @endif
         </div>
    </div>
@endsection