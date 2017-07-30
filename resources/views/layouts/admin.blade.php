<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        @include('partials._head')
    </head>

    <body>
        <div id="app">
            <div id="wrapper" class="active">
                <!-- Sidebar -->
                @if(Auth::check())
                    @include('partials._sidebar_admin')
                @endif
                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <!-- Keep all page content within the page-content inset div! -->
                    <div class="container-fluid page-content inset">
                        <div class="row">
                            <div class="col-md-12">
                                @include('partials._messages')
                                @yield('data') 
                            </div>
                        </div>
                    </div>
                    @if(Auth::check())
                        <!-- User Options -->
                        <div class="user-options" id="collapseUser">
                            <ul class="sidebar-nav" id="sidebar">
                                <li>
                                    <a href="{{ route('users.show', Auth::user()->id) }}">
                                        <span class="glyphicon glyphicon-cog"></span>  Perfil
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                        <span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                    <!-- Footer -->
                    @include('partials._footer')
                </div>
            </div><!-- /#page-content-wrapper -->
            @include('partials._javascripts')
        </div>
        @yield('scripts')
        <!-- Menu Toggle Script -->
        <script>
            $(function() {
                var windowsize = $(window).width();
                if (windowsize <= 1024 ) {
                    $("#wrapper").removeClass("active");
                }else {
                    $("#wrapper").addClass("active");
                }

                $(window).resize(function() {
                    windowsize = $(window).width();
                    if (windowsize <= 1024 ) {
                        $("#wrapper").removeClass("active");
                    }else {
                        $("#wrapper").addClass("active");
                    }
                });

                $('#collapseUser').hide();

                $('#collapseUserOptions').click(function () {
                    $('#collapseUser').toggle();
                })
                $.support.transition = false;
            });
        </script>
    </body>
</html>