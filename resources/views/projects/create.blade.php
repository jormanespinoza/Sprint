@extends('layouts.app')

@section('title', '| Crear Proyecto')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Crear Nuevo Proyecto</div>
                <div class="panel-body">
                    {{ Form::open(['route' => 'projects.store', 'class' => 'form-vertical', 'data-parsley-validate' => '']) }}
                        {{ csrf_field() }}

                        <div class="form-group">
                            {{ Form::label('name', 'Nombre del Proyecto:', ['class' => 'control-label', 'for' => 'name']) }}
                            {{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'minlength' => '2', 'maxlength' => '255']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('description', 'Descripción Proyecto:', ['class' => 'control-label', 'for' => 'description']) }}
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'for' => 'description', 'required' => '', 'minlength' => '4'])}}
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                {{ Form::submit('Generar', ['class' => 'btn btn-primary btn-block'])}}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
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
            lang: 'es'
        });
    </script>
@endsection