@extends('layouts.app')

@section('title', '| Nuevo Sprint')

@section('stylesheets')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}">
                <span class="glyphicon glyphicon-folder-close"></span> Proyectos
            </a>
        </li>
        <li class="active">
            <a href="{{ route('project.show', $project->id) }}">
                <span class="glyphicon glyphicon-folder-open"></span> {{ $project->name }}
            </a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-inbox"></span> Nuevo Sprint
        </li>
    </ol>

    <h5><span class="glyphicon glyphicon-inbox"></span> Nuevo Sprint</h5>
    <hr>
    <div class="col-md-12">
         {{ Form::open(['route' => ['sprint.store', $project->id]]) }}
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {{ Form::label('name', 'Nombre') }}
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        {{ Form::label('description', 'Descripción') }}
                        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('starts_on') ? ' has-error' : '' }}">
                        {{ Form::label('starts_on', 'Fecha de Inicio') }}
                        {{ Form::date('starts_on', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
                        @if ($errors->has('starts_on'))
                            <span class="help-block">
                                <strong>{{ $errors->first('starts_on') }}</strong>
                            </span>
                        @endif
                    </div>
                
                    <div class="form-group{{ $errors->has('ends_on') ? ' has-error' : '' }}">
                        {{ Form::label('ends_on', 'Fecha de Cierre') }}
                        {{ Form::date('ends_on', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
                        @if ($errors->has('ends_on'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ends_on') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::submit('Crear Sprint', ['class' => 'btn btn-block btn-success']) }}
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