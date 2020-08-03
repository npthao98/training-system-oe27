<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>@yield('title')</title>
        <meta name="description" content="Responsive, Bootstrap, BS4"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <link rel="stylesheet" href="{{ asset('bower_components/bower_package/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/bower_package/css/theme.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_header.css') }}">
        @yield('css')
    </head>
    <body class="layout-row">
        @include('supervisor.layouts.menu')
        <div id="main" class="layout-column flex">
            @include('supervisor.layouts.header')
            @yield('content')
        </div>
        <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/pjax/pjax.min.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/js/lazyload.config.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/js/lazyload.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/js/plugin.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/scrollreveal/dist/scrollreveal.min.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/feather-icons/dist/feather.min.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/js/plugins/feathericon.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/js/theme.js') }}"></script>
        <script src="{{ asset('bower_components/bower_package/js/utils.js') }}"></script>
        @yield('js')
    </body>
</html>
