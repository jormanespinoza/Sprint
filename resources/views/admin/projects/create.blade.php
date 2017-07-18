@extends('layouts.admin')

@section('title', '| Crear Proyecto')

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
            <span class="glyphicon glyphicon-file"></span> Nuevo
        </li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">Crear Nuevo Proyecto</div>
        <div class="panel-body">
            {{ Form::open(['route' => 'projects.store', 'class' => 'form-vertical', 'data-parsley-validate' => '']) }}
                {{ csrf_field() }}

                <div class="form-group">
                    {{ Form::label('name', 'Nombre', ['class' => 'control-label', 'for' => 'name']) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'minlength' => '2', 'maxlength' => '255']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('description', 'Descripción', ['class' => 'control-label', 'for' => 'description']) }}
                    {{ Form::textarea('description', null, ['class' => 'form-control', 'for' => 'description', 'required' => '', 'minlength' => '4'])}}
                </div>

               <div class="form-group" title="Asignar uno o más líderes de proyecto">
                    {{ Form::label('leaders', 'Líder de Proyecto') }}
                    <select name="leaders[]" class="form-control js-select2" multiple="multiple">
                        @foreach($leaders as $leader)
                            <option value="{{ $leader->id }}">{{ $leader->last_name }} {{ $leader->first_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" title="Asignar uno o más desarrolladores para el proyecto">
                    {{ Form::label('developers', 'Desarrollador') }}
                    <select name="developers[]" class="form-control js-select2" multiple="multiple">
                        @foreach($developers as $developer)
                            <option value="{{ $developer->id }}">{{ $developer->last_name }} {{ $developer->first_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" title="Asignar uno o más clientes al proyecto">
                    {{ Form::label('clients', 'Cliente') }}
                    <select name="clients[]" class="form-control js-select2" multiple="multiple">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->last_name }} {{ $client->first_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{ Form::submit('Generar', ['class' => 'btn btn-primary btn-block'])}}
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