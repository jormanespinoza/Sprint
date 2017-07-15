@extends('layouts.admin')

@section('title' ,'| Panel de Administractión')

@section('stylesheets')
    <style>
        /* make sidebar nav vertical */ 
        @media (min-width: 768px) {
        .sidebar-nav .navbar .navbar-collapse {
            padding: 0;
            max-height: none;
        }
        .sidebar-nav .navbar ul {
            float: none;
            display: block;
        }
        .sidebar-nav .navbar li {
            float: none;
            display: block;
        }
        .sidebar-nav .navbar li a {
            padding-top: 12px;
            padding-bottom: 12px;
        }
}
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
        <div class="col-sm-2">
            <div class="sidebar-nav">
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="visible-xs navbar-brand">Administrar</span>
                    </div>
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="#"><span class="glyphicon glyphicon-user">
                                    </span> Usuarios <span class="caret">
                                </a> 
                            </li>
                            <li>
                                <a href="#">
                                    <span class="glyphicon glyphicon-briefcase"></span> Proyectos <span class="caret">
                                </a>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="row">
                    <div class="col-md-12">
                        @include('partials._messages')
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Panel de Administración
                            </div>
                            <div class="panel-body">
                                <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam accusamus, nam dolores delectus ipsa repudiandae ea saepe, itaque inventore. Voluptatibus ad cumque recusandae culpa ipsum dolores eum laboriosam dolor nobis.</div>
                                <div>Voluptatibus fugit id impedit vero ratione optio, quas, rem praesentium quo quae animi eaque consequatur illo ipsa non quibusdam in. Ea, fugit, iure. Illo recusandae, maxime accusamus beatae! Rerum, beatae.</div>
                                <div>Deleniti reiciendis, aliquid illo cumque totam atque minus ea quia nihil quisquam consequuntur labore eum ut animi iure quis eius excepturi explicabo esse dolorem quidem debitis voluptatem! Facilis, repellat, accusantium.</div>
                                <div>Labore obcaecati eum nobis nulla tempora fuga maiores quidem molestiae aspernatur veniam. Quia nam inventore neque odit vel facilis nulla dolores quisquam, fugiat sint necessitatibus minima. Ducimus nisi velit repellendus.</div>
                                <div>Commodi eligendi tempore eius labore, et necessitatibus autem, earum, ex iste illo vel magnam delectus illum qui hic corporis porro doloremque aut aliquam. Distinctio mollitia praesentium sapiente quibusdam, dolores libero!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection