@extends('layouts.app')

@section('title', '| Contacto')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Formulario de Contacto</h1>
                <p>Puedes ingresar observaciones mediante el siguiente formulario</p>
                <hr>
                <form action="{{ url('contact') }}" method="POST" data-parsley-validate="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label name="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label name="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" class="form-control" required max-length="255">
                    </div>

                    <div class="form-group">
                        <label name="message">Message:</label>
                        <textarea id="message" name="message" class="form-control"  placeholder="Type your text here..." required></textarea>
                    </div>

                    <input type="submit" class="btn btn-success" value="Send Message">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
@endsection