@extends('layouts.app')

@section('title', '| Contacto')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1>Formulario de Contacto</h1>
                <p>Puedes ingresar observaciones mediante el siguiente formulario</p>
                <hr>
                <form action="{{ url('contact') }}" method="POST" data-parsley-validate="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label name="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label name="subject">Asunto:</label>
                        <input type="text" id="subject" name="subject" class="form-control" required max-length="255">
                    </div>

                    <div class="form-group">
                        <label name="message">Mensaje:</label>
                        <textarea id="message" name="message" class="form-control" placeholder="Ingresa tu mensaje aquí..." required></textarea>
                    </div>

                    <input type="submit" class="btn btn-success" value="Enviar Mensaje">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! Html::script('js/parsley.js') !!}
    {!! Html::script('plugins/trumbowyg/trumbowyg.js') !!}
    {!! Html::script('plugins/trumbowyg/langs/es.min.js') !!}
    <script>
        $('textarea').trumbowyg({
            lang: 'es',
            btns: [
                ['viewHTML'],
                ['formatting'],
                'btnGrp-semantic',
                ['superscript', 'subscript'],
                ['link'],
                'btnGrp-justify',
                'btnGrp-lists',
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ]
        });
    </script>
@endsection