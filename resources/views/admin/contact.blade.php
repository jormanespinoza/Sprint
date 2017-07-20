@extends('layouts.admin')

@section('title', '| Contacto')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('data')
    <ol class="breadcrumb">
       @include('partials._toggle_menu')
        <li>
            <a href="{{ url('admin') }}"><span class="glyphicon glyphicon-th-large"></span> Inicio</a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-envelope"></span> Contacto
        </li>
    </ol>
    <h1>Formulario de Contacto</h1>
    <p>Puedes ingresar observaciones mediante el siguiente formulario</p>
    <hr>
    <form action="{{ url('contact') }}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}">

        <div class="form-group">
            <label name="subject">Asunto</label>
            <input type="text" id="subject" name="subject" class="form-control" required max-length="255">
        </div>

        <div class="form-group">
            <label name="message">Mensaje</label>
            <textarea id="message" name="message" class="form-control" placeholder="Ingresa tu mensaje aquí..." required minlength="4"></textarea>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-block btn-success" value="Enviar Mensaje">
        </div>
    </form>
@endsection

@section('scripts')
    {!! Html::script('js/parsley.js') !!}
    {!! Html::script('plugins/trumbowyg/trumbowyg.js') !!}
    {!! Html::script('plugins/trumbowyg/langs/es.min.js') !!}
    <script>
        $('textarea').trumbowyg({
            lang: 'es'
        });
    </script>
@endsection