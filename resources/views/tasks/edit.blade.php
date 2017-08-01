@extends('layouts.app')

@section('title', '| Editar Tarea')

@section('stylesheets')
    {!! Html::style('plugins/trumbowyg/ui/trumbowyg.css') !!}
@endsection

@section('content')
    <h5><span class="glyphicon glyphicon-save-file"></span> Editar Tarea</h5>
    <hr>
    <div class="col-md-12">
        {!! Form::model($task, ['route' => ['task.update', $project->id, $sprint->id, $task->id], 'novalidate' => '']) !!}
            {{ csrf_field() }}
            {{ Form::hidden('_method', 'PUT') }}

            <div class="row">
                @if($task->status_id == 1 || Auth::user()->role_id == 2)
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
                                {{ Form::select('hours', [
                                    '1' => 1,
                                    '2' => 2,
                                    '3' => 3,
                                    '5' => 5,
                                    '8' => 8,
                                    '13' => 13], $task->hours, ['id' => 'hours', 'class' => 'form-control']) }}
                                <span class="input-group-addon" id='hours'><span class="glyphicon glyphicon-time"></span></span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-9 col-sm-9">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
                            <div class="input-group">
                                {{ Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                                <span class="input-group-addon" id='name'><span class="glyphicon glyphicon-tag"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                            {{ Form::label('hours', 'Número de Horas', ['class' => 'control-label']) }}
                            <div class="input-group">
                                {{ Form::number('hours', null, ['id' => 'hours', 'class' => 'form-control', 'disabled' => 'disabled']) }}
                                <span class="input-group-addon" id='hours'><span class="glyphicon glyphicon-time"></span></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {{ Form::label('description', 'Descripción', ['class' => 'control-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control']) }}
            </div>
            @if ($task->status_id == 5)
                {{ Form::submit('Actualizar', ['class' => 'btn btn-block btn-primary']) }}
            @else
                {{ Form::submit('Actualizar', ['class' => 'btn btn-block btn-primary']) }}
            @endif
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