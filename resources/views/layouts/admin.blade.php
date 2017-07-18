<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        @include('partials._head')
    </head>

    <body>
        <div id="app">
            <div id="wrapper" class="toggled">
                <!-- Sidebar -->
                @include('partials._sidebar')

                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                @include('partials._messages')
                                @yield('data')
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    @include('partials._footer')
                </div>
            </div><!-- /#page-content-wrapper -->
            @include('partials._javascripts')
        </div>
        @yield('scripts')
        <!-- Menu Toggle Script -->
        <script>
            if ($("#wrapper").hasClass("toggled")) {
                $("#menu-show").hide();
            }

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