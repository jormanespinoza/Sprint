@extends('layouts.admin')

@section('title', '| Editar Proyecto')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('data')
    <ol class="breadcrumb">
        @include('partials._toggle_menu')
        <li>
            <a href="{{ url('admin') }}"><span class="glyphicon glyphicon-th-large"></span> Inicio</a>
        </li>
        <li>
            <a href="{{ url('admin/projects') }}"><span class="glyphicon glyphicon-folder-close"></span> Proyectos</a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-edit"></span> Editar Proyecto
        </li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">Crear Nuevo Proyecto</div>
        <div class="panel-body">
            {!! Form::model($project, ['route' => ['projects.update', $project->id], 'class' => 'form-vertical', 'data-parsley-validate' => '']) !!}
                {{ csrf_field() }}
                {{ Form::hidden('_method', 'PUT') }}

                <div class="form-group">
                    {{ Form::label('name', 'Nombre del Proyecto', ['class' => 'control-label', 'for' => 'name']) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'minlength' => '2', 'maxlength' => '255']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('description', 'Descripción Proyecto', ['class' => 'control-label', 'for' => 'description']) }}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'for' => 'description', 'required' => '', 'minlength' => '4'])!!}
                </div>

                {{--  <div class="form-group">
                    {{ Form::label('leaders', 'Líderes de Proyecto') }}
                    <select name="leaders[]" class="form-control js-select2" multiple="multiple">
                        @foreach($leaders as $leader)
                            <option value="{{ $leader->id }}">{{ $leader->last_name }} {{ $leader->first_name }}</option>
                        @endforeach
                    </select>
                </div>  --}}

                {{ Form::submit('Actualizar Proyecto', ['class' => 'btn btn-block btn-primary']) }}

            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
    {!! Html::script('js/parsley.js') !!}
    {!! Html::script('js/select2.min.js') !!}
    {!! Html::script('plugins/trumbowyg/trumbowyg.js') !!}
    {!! Html::script('plugins/trumbowyg/langs/es.min.js') !!}
    <script>
        $('textarea').trumbowyg({
            lang: 'es'
        });
        $(document).ready(function() {
            $(".js-select2").select2();
        });
    </script>
@endsection