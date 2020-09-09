<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>@yield('title')</title>
        <meta name="description" content="Responsive, Bootstrap, BS4"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('bower_components/bower_package/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/bower_package/css/theme.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_header.css') }}">
        <script src="{{ asset('bower_components/pusher-js/dist/web/pusher.min.js') }}"></script>
        <link rel="stylesheet" type="text/css"  href="{{ asset('css/notification.css') }}">
        @yield('css')
    </head>
    <body class="layout-row">
        @include('trainee.layouts.menu')
        <div id="main" class="layout-column flex">
            @include('trainee.layouts.header')
            @yield('content')
        </div>
        <script>
            const array_const = [];
            array_const['added_course'] = "{{ trans('trainee.notification.added_course') }}";
            array_const['actived_course'] = "{{ trans("trainee.notification.actived_course") }}";
            array_const['review_task'] = "{{ trans("trainee.notification.review_task") }}";
        </script>
        <script src="{{ asset('js/pusher.js') }}"></script>
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
