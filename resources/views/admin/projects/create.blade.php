@extends('layouts.admin')

@section('title', '| Crear Proyecto')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('data')
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Inicio</a></li>
        <li><a href="{{ url('admin/projects') }}">Proyectos</a></li>
        <li class="active">Nuevo Proyecto</li>
    </ol>

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

                {{ Form::submit('Generar', ['class' => 'btn btn-primary btn-block'])}}
            {{ Form::close() }}
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