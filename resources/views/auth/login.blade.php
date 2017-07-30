@extends('layouts.app')

@section('title', '| Acceso')

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3" style="margin-top: 20px;">
            <div class="text-center" style="margin-bottom: 20px;">
                <a href="{{ url('/') }}">
                    <img src="{{ url('images/logo.png')}}" class="logo-login" alt="Logo de 3D Sprint">
                </a>
                <h4><strong>Ingresa a {{ config('app.name', 'Laravel') }}</strong></h4>
            </div>
            <div class="panel panel-default">
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
    </div>
@endsection
