@extends('layouts.app')

@section('title', '| Acceso')

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form" method="POST" action="{{ route('login') }}" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Contraseña</label>
                            <a class="pull-right" href="{{ route('password.request') }}">
                                ¿Olvidaste tu Contraseña?
                            </a>
                            <input id="password" type="password" class="form-control" name="password" required>

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
