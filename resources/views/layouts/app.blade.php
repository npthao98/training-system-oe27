<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower_package/css/theme.css') }}">
    @yield('css')
</head>
<body>
    @guest
        <div class="bg-sun">
            <div>
                <a href="#" class="navbar-brand float-left">
                    <img src="{{ asset(config('image.logo')) }}"
                        alt="logo" class="logo">
                </a>
                <div class="mb-2 float-right language">
                    <div class="navbar-header language">
                        <a class="navbar-brand float-left"
                           href="{{ route('user.change-language', ['en']) }}">
                            <img class="language-image" src="{{ asset(config('image.en')) }}"
                                alt="{{ trans('trainee.app.english') }}">
                        </a>
                        <a class="navbar-brand float-left"
                           href="{{ route('user.change-language', ['vi']) }}">
                            <img src="{{ asset(config('image.vi')) }}"
                                alt="{{ trans('trainee.app.vietnam') }}" class="language-image">
                        </a>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    @else
        <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button"
                    data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ trans('auth.toggle_navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    {{ trans('auth.login') }}
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        {{ trans('auth.register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle"
                                    href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="navbarDropdown">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="border-0 bt-logout">
                                            {{ trans('supervisor.app.sign_out') }}
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @endguest
</body>
</html>
