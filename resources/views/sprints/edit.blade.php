@extends('layouts.app')

@section('title', '| Editar Sprint')

@section('stylesheets')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}">
                <span class="glyphicon glyphicon-dashboard"></span> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('project.show', $project->id) }}">
                <span class="glyphicon glyphicon-folder-open"></span> {{ $project->name }}
            </a>
        </li>
        <li>
            <a href="{{ route('sprint.show', [$project->id, $sprint->id]) }}">
                <span class="glyphicon glyphicon-tasks"></span> {{ $sprint->name }}
            </a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-edit"></span> Actualizar
        </li>
    </ol>

    <h5><span class="glyphicon glyphicon-inbox"></span> Actualizar Sprint</h5>
    <hr>
    <div class="col-md-12">
         {!! Form::model($sprint, ['route' => ['sprint.update', $project->id, $sprint->id]]) !!}
            {{ csrf_field() }}
            {{ Form::hidden('_method', 'PUT') }}
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {{ Form::label('name', 'Nombre') }}
                        <div class="input-group">
                            <span class="input-group-addon" id="name"><span class="glyphicon glyphicon-tag"></span></span>
                            {{ Form::text('name', null, ['class' => 'form-control']) }}
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-grou{{ $errors->has('description') ? ' has-error' : '' }}p">
                        {{ Form::label('description', 'Descripción') }}
                        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    {{ Form::hidden('user_id', Auth::user()->id) }}
                </div>

                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('starts_on') ? ' has-error' : '' }}">
                        {{ Form::label('starts_on', 'Fecha de Inicio') }}
                        <div class="input-group">
                            <span class="input-group-addon" id="ends_on"><span class="glyphicon glyphicon-calendar"></span></span>
                            {{ Form::date('starts_on', $sprint->starts_on, ['class' => 'form-control']) }}
                        </div>
                        @if ($errors->has('starts_on'))
                            <span class="help-block">
                                <strong>{{ $errors->first('starts_on') }}</strong>
                            </span>
                        @endif
                    </div>
                
                    <div class="form-group{{ $errors->has('ends_on') ? ' has-error' : '' }}">
                        {{ Form::label('ends_on', 'Fecha de Cierre') }}
                        <div class="input-group">
                            <span class="input-group-addon" id="ends_on"><span class="glyphicon glyphicon-calendar"></span></span>
                            {{ Form::date('ends_on', $sprint->ends_on, ['class' => 'form-control']) }}
                        </div>
                        @if ($errors->has('ends_on'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ends_on') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                        {{ Form::label('hours', 'Horas') }}
                        <div class="input-group">
                            <span class="input-group-addon" id="ends_on"><span class="glyphicon glyphicon-time"></span></span>
                            {{ Form::number('hours', null, ['class' => 'form-control', 'placeholder' => '40']) }}
                        </div>
                        @if ($errors->has('hours'))
                            <span class="help-block">
                                <strong>{{ $errors->first('hours') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::submit('Actualizar Sprint', ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection

@section('scripts')
    {!! Html::script('plugins/trumbowyg/trumbowyg.js') !!}
    {!! Html::script('plugins/trumbowyg/langs/es.min.js') !!}
    <script>
        $('textarea').trumbowyg({
            lang: 'es'
        });
    </script>
@endsection