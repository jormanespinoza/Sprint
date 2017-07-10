<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        @include('partials._head')
    </head>

    <body>
        <div id="app">
            @include('partials._navbar')

            <div class="container">
                @include('partials._messages')
                @yield('content')
                @include('partials._footer')
            </div>

            @include('partials._javascripts')
        </div>
        @yield('scripts')
    </body>

</html>