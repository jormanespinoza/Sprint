@extends('layouts.admin')

@section('title', '| Editar Proyecto')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.css') !!}
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('data')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('admin') }}">
                <span class="glyphicon glyphicon-dashboard"></span> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ url('admin/projects') }}">
                <span class="glyphicon glyphicon-folder-close"></span> Proyectos
            </a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-edit"></span> Actualizar Proyecto
        </li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">Editar Proyecto</div>
        <div class="panel-body">
            {!! Form::model($project, ['route' => ['projects.update', $project->id], 'class' => 'form-vertical', 'data-parsley-validate' => '']) !!}
                {{ csrf_field() }}
                {{ Form::hidden('_method', 'PUT') }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {{ Form::label('name', 'Nombre del Proyecto', ['class' => 'control-label', 'for' => 'name']) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'minlength' => '2', 'maxlength' => '255']) }}
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    {{ Form::label('description', 'Descripción Proyecto', ['class' => 'control-label', 'for' => 'description']) }}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'for' => 'description', 'required' => '', 'minlength' => '4'])!!}
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('develop_url') ? ' has-error' : '' }}">
                            {{ Form::label('develop_url', 'URL Desarrollo', ['class' => 'control-label', 'for' => 'description']) }}
                            {{ Form::text('develop_url', null, ['class' => 'form-control', 'for' => 'develop_url']) }}
                            @if ($errors->has('develop_url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('develop_url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('production_url') ? ' has-error' : '' }}">
                            {{ Form::label('production_url', 'URL Producción', ['class' => 'control-label', 'for' => 'description']) }}
                            {{ Form::text('production_url', null, ['class' => 'form-control', 'for' => 'production_url']) }}
                            @if ($errors->has('production_url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('production_url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('leaders', 'Líder de Proyecto') }}
                    {{ Form::select('users[]', $leaders, null, ['class' => 'form-control js-select2', 'multiple' => 'multiple']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('developers', 'Desarrollador') }}
                    {{ Form::select('users[]', $developers, null, ['class' => 'form-control js-select2', 'multiple' => 'multiple']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('client', 'Cliente') }}
                    {{ Form::select('users[]', $clients, null, ['class' => 'form-control js-select2', 'multiple' => 'multiple']) }}
                </div>

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