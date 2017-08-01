@extends('layouts.app')

@section('title', '| Crear Tarea')

@section('stylesheets')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('content')
    <h5><span class="glyphicon glyphicon-save-file"></span> Crear Nueva Tarea</h5>
    <hr>
    <div class="col-md-12">
        {{ Form::open(['route' => ['task.store', $project->id, $sprint->id], 'novalidate' => '']) }}
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-9 col-sm-9">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
                        <div class="input-group">
                            {{ Form::text('name', null, ['class' => 'form-control']) }}
                            <span class="input-group-addon" id='name'><span class="glyphicon glyphicon-tag"></span></span>
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-3 col-sm-3">
                    <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                        {{ Form::label('hours', 'Número de Horas', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <select name="hours" class="form-control" id="hours">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                                <option value="8">8</option>
                                <option value="13">13</option>
                            </select>
                            <span class="input-group-addon" id='hours'><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {{ Form::label('description', 'Descripción', ['class' => 'control-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control']) }}
            </div>

            {{ Form::submit('Crear', ['class' => 'btn btn-block btn-success']) }}
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