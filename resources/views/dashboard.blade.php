@extends('layouts.app')

@section('title', '| Escritorio')

@section('stylesheets')
    {!! Html::style('css/semantic.css') !!}
@endsection

@section('content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('dashboard') }}">
                <span class="glyphicon glyphicon-dashboard"></span> Dashboard
            </a>
        </li>
    </ol>

    <h5 class="text-right"><span class="glyphicon glyphicon-folder-close"> </span> Proyectos</h5>

    <div class="ui divider"></div>

    <div class="row">
        @if(count(Auth::user()->projects) > 0)
            @foreach(Auth::user()->projects as $project)
                <div class="col-lg-3 col-md-4 col-sm-6 card-project">
                    <div class="ui card">
                        {{--  <div class="image">
                            <img src="https://laraveles.com/wp-content/uploads/2016/09/laravel-2.jpg" class="visible content">
                        </div>  --}}
                        <div class="content">
                            <div class="header">
                                {{ substr($project->name, 0, 17) }} {{ strlen($project->name) > 17 ? '...' : '' }}
                            </div>
                        </div>
                        <div class="content">
                            <div class="ui small feed">
                                @if(Auth::user()->role_id != 4)
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
                                        <div class="ui divider"></div>
                                    @endif
                                @endif
                                    @if($project->description != null)
                                        {{ substr($project->description, 0, 110) }} {{ strlen($project->description) > 110 ? '...' : '' }}
                                    @else
                                        <span class="text-warning">
                                            <span class="glyphicon glyphicon-info-sign"></span> Sin descripción
                                        </span>
                                    @endif
                                </div>
                        </div>
                        <div class="extra content">
                            <a class="ui button" href="{{ route('project.show', $project->id) }}">Ver Proyecto</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="alert alert-info">
                    <span class="glyphicon glyphicon-info-sign"></span> <strong>No tienes proyectos asignados en este momento.</strong>
                </div>
            </div>
        @endif
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