@extends('layouts.admin')

@section('title', '| Proyectos')

@section('stylesheets')
    {!! Html::style('css/semantic.css') !!}
@endsection

@section('data')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('admin') }}">
                <span class="glyphicon glyphicon-dashboard"></span> Dashboard
            </a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-folder-close"></span> Proyectos
        </li>
    </ol>

    <div class="row">
        <div class="col-md-8 col-xs-8">
            <div class="heading-title">
                Lista de Proyectos | <span class="label label-primary">
                    <strong>Total {{ count($all_projects) }}</strong></span>
            </div>
        </div>
        <div class="col-md-4 col-xs-4">
            <span class="pull-right">
                <a href="{{ Route('projects.create') }}" class="btn btn-sm btn-primary" title="Crear Proyecto">
                    <span class="glyphicon glyphicon-file"></span> Nuevo
                </a>
            </span>
        </div>
    </div>

    <div class="ui divider"></div>
    @if(count($all_projects) > 0)
        <div class="row">
            @foreach($projects as $project)
                <div class="col-lg-3 col-md-4 col-sm-6 card-project">
                    <div class="ui card">
                        {{-- <div class="image">
                            <img src="https://laraveles.com/wp-content/uploads/2016/09/laravel-2.jpg" class="visible content">
                        </div> --}}
                        <div class="content">
                            <div class="header">
                                {{ substr($project->name, 0, 17) }} {{ strlen($project->name) > 17 ? '...' : '' }}
                                <div class="ui buttons pull-right">
                                <div class="ui floating dropdown icon button">
                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                    <div class="menu">
                                        <div class="item">
                                            <a href="{{ route('projects.show', $project->id) }}">
                                                <span class="glyphicon glyphicon-folder-open"></span> Abrir Proyecto
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="{{ route('projects.edit', $project->id) }}">
                                                <span class="glyphicon glyphicon-edit"></span> Editar Proyecto
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a data-toggle="modal" role="button" data-target="#confirmationModal-{{ $project->id }}">
                                                <span class="glyphicon glyphicon-erase"></span> Borrar Proyecto
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="ui small feed">
                                @if(count($project->users) > 0)
                                    @foreach($project->users->sortBy('role_id') as $user)
                                        <div class="event">
                                            <div class="content">
                                                <div class="summary">
                                                    @php 
                                                        switch ($user->role->id) {
                                                            case 1:
                                                                $label_class = 'label-success';
                                                                break;
                                                            case 2:
                                                                $label_class = 'label-primary';
                                                                break;
                                                            case 3:
                                                                $label_class = 'label-info';
                                                                break;
                                                            default:
                                                                $label_class = 'label-default';
                                                                break;
                                                        }
                                                    @endphp
                                                    <span class="label {{ $label_class }}"><b>{{ $user->role->name }}</b></span> {{ $user->last_name }} {{ $user->first_name }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="event">
                                        <div class="content">
                                            <div class="summary">
                                                <span class="text-warning">
                                                    <span class="glyphicon glyphicon-info-sign"></span> No hay personal asignado.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                            </div>
                        </div>
                        <div class="extra content">
                            <a class="ui button" href="{{ route('projects.show', $project->id) }}">Ver Proyecto</a>
                        </div>
                    </div>
                </div>

                {{-- Remove Project Confirmation Modal --}}
                <div class="modal fade" tabindex="-1" role="dialog" id="confirmationModal-{{ $project->id }}">
                    <div class="modal-dialog" role="dialog" id="model-{{ $project->id }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Confirmación</h4>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro deseas eliminar el proyecto <strong>{{ $project->name }}</strong>?</p>
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
            @endforeach
        </div>
    @else
        <div class="list-group">
            <div class="list-group-item">
                <span class="glyphicon glyphicon-info-sign"></span> No hay proyectos generados en el sistema.
            </div>
        </div>
    @endif

    <div class="text-center">
        {{ $projects->links( )}}
    </div>
@endsection

@section('scripts')
    {!! Html::script('js/semantic.js') !!}
    <script>
        $('.ui.dropdown')
            .dropdown()
        ;
    </script>
@endsection