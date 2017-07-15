<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        @include('partials._head')
    </head>

    <body>
        <div id="app">
            @include('partials._navbar')

            <div id="wrapper" class="toggled">
                <!-- Sidebar -->
                @include('partials._sidebar')
                <!-- /#sidebar-wrapper -->

                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        @yield('data')
                        <!-- Footer -->
                        @include('partials._footer')
                        <!-- /#page-content-wrapper -->
                    </div>
                </div>
            </div>
            @include('partials._javascripts')
        </div>
        @yield('scripts')
        <!-- Menu Toggle Script -->
        <script>
            $(function() {
                if ($("#wrapper").hasClass("toggled")) {
                    $("#menu-show").hide();
                }
            });

            $("#menu-hide").click(function(e) {
                e.preventDefault();
                $("#wrapper").removeClass("toggled");
                $("#menu-show").show();
            });
            $("#menu-show").click(function(e) {
                e.preventDefault();
                $("#wrapper").addClass("toggled");
                $("#menu-show").hide();
            });
        </script>
    </body>
</html>