@extends('layouts.app')

@section('title', '| Proyecto ' . $project->name)

@section('stylesheets')
    {!! Html::style('css/select2.min.css') !!}
@endsection

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}"><span class="glyphicon glyphicon-folder-close"></span> Proyectos</a>
        </li>
        <li class="active">
            <span class="glyphicon glyphicon-folder-open"></span> {{ $project->name }}
        </li>
    </ol>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8 col-xs-6">
                    <span>{{ $project->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="well" title="Descripción del Proyecto">
        {!! $project->description !!}
    </div>

    <div class="row list-group">
        @if(Auth()->user()->role_id != 4)
            <div class="col-md-6">
                <div class="list-group-item">
                    <strong>URL Desarrollo:</strong> <a href="{{ $project->develop_url }}" target="_black">{{ $project->develop_url }}</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="list-group-item">
                    <strong>URL Producción:</strong> <a href="{{ $project->develop_url }}" target="_black">{{ $project->develop_url }}</a>
                </div>
            </div>
        @else
            <div class="col-md-6 col-md-offset-6">
                <div class="list-group-item">
                    <strong>URL del Proyecto:</strong> <a href="{{ $project->develop_url }}" target="_black">{{ $project->production_url }}</a>
                </div>
            </div>
        @endif
    </div>

    <div class="clearfix"></div>

    <div class="{{ Auth::user()->role_id == 4 ? "col-md-12" : "col-md-8" }}">
        <div class="row">
            <div class="col-md-9 col-xs-6">
                <h5>
                    <span class="glyphicon glyphicon-inbox"></span> <strong>Sprints</strong> 
                    <a type="button" data-toggle="modal" data-target="#statusSprintModal" title="Estados">
                        <span class="glyphicon glyphicon-info-sign"></span>
                    </a>
                </h5>
            </div>
            <div class="col-md-3 col-xs-6">
                @if(Auth::user()->role_id == 2)
                    <div class="btn-new-task text-right">
                        <a href="{{ route('sprint.create', $project->id) }}" class="btn btn-sm btn-success text-right"><span class="glyphicon glyphicon-inbox"></span> Añadir Sprint</a>
                    </div>
                @endif
            </div>
        </div>

        @if(count($project->sprints) > 0)
            <div class="list-group">
            @foreach($project->sprints->sortBy('created_at') as $sprint)
                <a href="{{ route('sprint.show', [$project->id, $sprint->id]) }}" class="list-group-item list-group-item-{{ $sprint->done ? "success" : "action" }}">
                    <strong><span class="glyphicon glyphicon-{{ $sprint->done ? "share-alt" : "random"  }}"></span> {{ $sprint->name }}</strong>
                    @if($sprint->edited && Auth::user()->role_id != 4)
                        (Editado)
                    @endif
                    <span class="glyphicon glyphicon-open-file pull-right" title="Ver Sprint"></span>
                </a>
            @endforeach
        </div>
        @else
            <div class="alert alert-warning">
                <span class="glyphicon glyphicon-info-sign"></span> No se encuentran <strong>sprints</strong> generados.
            </div>
        @endif
    </div>

    @if(Auth::user()->role_id != 4)
        <div class="col-md-4">
            <div class="well">
                <div class="list-group">
                    <div class="list-group-item">
                        <h4><strong class="label label-primary">Líder de Proyecto</strong></h4>
                        @if($assigned_leader)
                            <ul class="list-group">
                                @foreach($project->users as $user)
                                    @if($user->role_id == 2)
                                        <div href="" class="list-group-item">
                                                <span class="glyphicon glyphicon-bookmark"></span> {{ $user->last_name }} {{ $user->first_name }}
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-default">
                                <span class="glyphicon glyphicon-info-sign"></span>No hay <strong>líderes</strong> asignados al proyecto. 
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
                                        <div class="list-group-item">
                                            <span class="glyphicon glyphicon-cog"></span> {{ $user->last_name }} {{ $user->first_name }}
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-default">
                                <span class="glyphicon glyphicon-info-sign"></span>No hay <strong>desarrolladores</strong> asignados al proyecto. 
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
                                        <div href="" class="list-group-item">
                                                <span class="glyphicon glyphicon-user"></span> {{ $user->last_name }} {{ $user->first_name }}
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-default">
                                <span class="glyphicon glyphicon-info-sign"></span>No hay <strong>clientes</strong> asignados al proyecto. 
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Status Sprint Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="statusSprintModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sprint</h4>
                </div>
                <div class="modal-body">
                    <span class="list-group-item list-group-item-default">
                        <strong><span class=""><span class="glyphicon glyphicon-random"></span> En Desarrollo</span></strong>
                         El Sprint se encuentra en desarrollo. 
                    </span>
                    <br>
                    <span class="list-group-item list-group-item-success">
                        <strong><span class=""><span class="glyphicon glyphicon-share-alt"></span> Completado</span></strong>
                         Todas las tareas del Sprint fueron completadas. 
                    </span>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <li>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <i class="glyphicon glyphicon-thumbs-up"></i> Bien!
                            </button>
                        </li>
                    </ul>
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
