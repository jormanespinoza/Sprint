@extends('layouts.admin')

@section('title', '| Proyecto ' . $project->name)

@section('stylesheets')
    {!! Html::style('css/select2.css') !!}
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
            <span class="glyphicon glyphicon-folder-open"></span> {{ $project->name }}
        </li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="project-title">
                <span>{{ $project->name }}</span>
                <a type="button" data-toggle="modal" data-target="#projectOptionsModal" title="Información">
                    <i class="glyphicon glyphicon-option-vertical"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="well" title="Descripción del Proyecto">
        {!! $project->description !!}
    </div>

    <div class="col-md-5">
        <h5>
            <span class="glyphicon glyphicon-tags"></span> <strong>Asignar Usuarios</strong>
        </h5>
        <hr>

        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" role="button" data-target="#updateLeadersModal-{{ $project->id }}">
            <span class="glyphicon glyphicon-bookmark"></span> Líder de Proyecto <span class="glyphicon glyphicon-pushpin pull-right"></span>
        </button>
        <button type="button" class="btn btn-block btn-info" data-toggle="modal" role="button" data-target="#updateDevelopersModal-{{ $project->id }}">
            <span class="glyphicon glyphicon-cog"></span> Desarrollador <span class="glyphicon glyphicon-pushpin pull-right"></span>
        </button>
        <button type="button" class="btn btn-block btn-default" data-toggle="modal" role="button" data-target="#updateClientsModal-{{ $project->id }}">
            <span class="glyphicon glyphicon-user"></span> Cliente <span class="glyphicon glyphicon-pushpin pull-right"></span>
        </button>

        <h5>
            <span class="glyphicon glyphicon-list-alt"></span> <strong>Información del Proyecto</strong>
        </h5>
        <hr>

        <div class="list-group">
            <div class="list-group-item">
                <strong>Creado:</strong> {{ $project->created_at->diffForHumans() }}
            </div>
            <div class="list-group-item">
                <strong>Última Actualización:</strong> {{ $project->updated_at->diffForHumans() }}
            </div>
            <div class="list-group-item">
                <strong>URL Desarrollo:</strong> 
                @if($project->develop_url != null)
                    <a href="{{ $project->develop_url }}" target="_blank">{{ $project->develop_url }}</a>
                @else
                    <span class="label label-default"> No asignada</span>
                @endif
            </div>
            <div class="list-group-item">
                <strong>URL Producción:</strong> 
                @if($project->production_url != null)
                        <a href="{{ $project->production_url }}" target="_blank">{{ $project->production_url }}</a>
                @else
                    <span class="label label-default"> No asignada</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <h5>
            <span class="glyphicon glyphicon-list-alt"></span> <strong>Personal Asignado</strong>
        </h5>
        <hr>

        <div class="list-group">
            <div class="list-group-item">
                <h4><strong class="label label-primary">Líder de Proyecto</strong></h4>
                @if($assigned_leader)
                    <ul class="list-group">
                        @foreach($project->users as $user)
                            @if($user->role_id == 2)
                                <a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item">
                                    <span class="glyphicon glyphicon-bookmark"></span> {{ $user->last_name }} {{ $user->first_name }}
                                    <span class="glyphicon glyphicon-link pull-right"></span>
                                </a>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-default">
                        <span class="glyphicon glyphicon-info-sign"></span> No se encuentra ningún <strong>líder</strong> asignado al proyecto. 
                    </div>
                @endif
            </div>
        </div>
        <div class="list-group">
            <div class="list-group-item">
                <h4><strong class="label label-info">Desarrollador</strong></h4>
                @if($assigned_developer)
                    <ul class="list-group">
                        @foreach($project->users as $user)
                            @if($user->role_id == 3)
                                <a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item-action">
                                    <span class="glyphicon glyphicon-cog"></span> {{ $user->last_name }} {{ $user->first_name }}
                                    <span class="glyphicon glyphicon-link pull-right"></span>
                                </a>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-default">
                        <span class="glyphicon glyphicon-info-sign"></span> No se encuentra ningún <strong>desarrollador</strong> asignado al proyecto. 
                    </div>
                @endif
            </div>
        </div>
        <div class="list-group">
            <div class="list-group-item">
                <h4><strong class="label label-default">Cliente</strong></h4>
                @if($assigned_client)
                    <ul class="list-group">
                        @foreach($project->users as $user)
                            @if($user->role_id == 4)
                                <a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item-action">
                                        <span class="glyphicon glyphicon-user"></span> {{ $user->last_name }} {{ $user->first_name }}
                                        <span class="glyphicon glyphicon-link pull-right"></span>
                                </a>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-default">
                        <span class="glyphicon glyphicon-info-sign"></span> No se encuentra ningún <strong>cliente</strong> asignado al proyecto.  
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <p>¿Seguro deseas eliminar este proyecto?</p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="glyphicon glyphicon-remove-sign"></i> No
                            </button>
                        </li>

                        <li>
                            {{ Form::open(['route' => ['projects.destroy', $project->id]]) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Sí', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Update Leaders Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="updateLeadersModal-{{ $project->id }}">
        <div class="modal-dialog" role="dialog" id="model-{{ $project->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-bookmark"></span> Asignar Líderes de Proyecto</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($project, ['route' => ['projects.updateAssignedUsers', $project->id]]) !!}
                        {{ csrf_field() }}
                        {{ Form::hidden('_method', 'PUT') }}
                        <div class="form-group">
                            {{ Form::select('users[]', $leaders, null, ['class' => 'form-control js-select2', 'multiple' => 'multiple', 'style' => 'width: 100%;']) }}
                            {{ Form::select('users[]', $developers, null, ['multiple' => 'multiple', 'class' => 'modal-select-hidden']) }}
                            {{ Form::select('users[]', $clients, null, ['multiple' => 'multiple', 'class' => 'modal-select-hidden']) }}
                        </div>
                        <div class="text-right">
                            <ul class="list-inline">
                                <li>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        <span class="glyphicon glyphicon-floppy-remove"></span> Cancelar
                                    </button>
                                </li>
                                <li>
                                    {{ Form::button('<i class="glyphicon glyphicon-floppy-saved"></i> Actualizar', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </li>
                            </ul>
                        </div>
                    {{ Form::close() }}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Update Developers Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="updateDevelopersModal-{{ $project->id }}">
        <div class="modal-dialog" role="dialog" id="model-{{ $project->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-cog"></span> Asignar Desarrolladores</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($project, ['route' => ['projects.updateAssignedUsers', $project->id]]) !!}
                        {{ csrf_field() }}
                        {{ Form::hidden('_method', 'PUT') }}
                        <div class="form-group">
                            {{ Form::select('users[]', $leaders, null, ['multiple' => 'multiple', 'class' => 'modal-select-hidden']) }}
                            {{ Form::select('users[]', $developers, null, ['class' => 'js-select2', 'multiple' => 'multiple', 'style' => 'width: 100%;']) }}
                            {{ Form::select('users[]', $clients, null, ['multiple' => 'multiple', 'class' => 'modal-select-hidden']) }}
                        </div>
                        <div class="text-right">
                            <ul class="list-inline">
                                <li>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        <span class="glyphicon glyphicon-floppy-remove"></span> Cancelar
                                    </button>
                                </li>
                                <li>
                                    {{ Form::button('<i class="glyphicon glyphicon-floppy-saved"></i> Actualizar', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </li>
                            </ul>
                        </div>
                    {{ Form::close() }}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Update Developers Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="updateClientsModal-{{ $project->id }}">
        <div class="modal-dialog" role="dialog" id="model-{{ $project->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-user"></span> Asignar Clientes</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($project, ['route' => ['projects.updateAssignedUsers', $project->id]]) !!}
                        {{ csrf_field() }}
                        {{ Form::hidden('_method', 'PUT') }}
                        <div class="form-group">
                            {{ Form::select('users[]', $leaders, null, ['multiple' => 'multiple', 'class' => 'modal-select-hidden']) }}
                            {{ Form::select('users[]', $developers, null, ['multiple' => 'multiple', 'class' => 'modal-select-hidden']) }}
                            {{ Form::select('users[]', $clients, null, ['class' => 'form-control js-select2', 'multiple' => 'multiple', 'style' => 'width: 100%;']) }}
                        </div>
                        <div class="text-right">
                            <ul class="list-inline">
                                <li>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        <span class="glyphicon glyphicon-floppy-remove"></span> Cancelar
                                    </button>
                                </li>
                                <li>
                                    {{ Form::button('<i class="glyphicon glyphicon-floppy-saved"></i> Actualizar', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </li>
                            </ul>
                        </div>
                    {{ Form::close() }}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Project Options Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="projectOptionsModal">
        <div class="modal-dialog" role="dialog" id="model-{{ $project->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-cog"></span> Opciones</h4>
                </div>
                <div class="modal-body">
                    <div class="text-right">
                        <ul class="list-inline">
                            <li>
                                {{-- Web View --}}
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-block btn-warning actions-show-project-web" title="Editar">
                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                </a>
                            </li>
                            <li>
                                {{-- Web View --}}
                                <a class="btn btn-block btn-danger actions-show-project-web" type="button" data-toggle="modal" data-target="#confirmationModal" title="Eliminar" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remove-circle"></span> Eliminar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('scripts')
    {!! Html::script('js/select2.min.js') !!}
    <script>
        $(document).ready(function() {
            $(".js-select2").select2();
        });
    </script>
@endsection
