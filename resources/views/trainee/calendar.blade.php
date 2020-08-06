@extends('trainee.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('bower_components/bower_package/css/bootstrap.css') }}">
    <script src="{{ asset('bower_components/bower_package/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/trainee_calendar.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/calendar.css') }}">
@endsection
@section('content')
    <div class="content">
        <div id='wrap'>
            <div id='calendar'></div>
        </div>
    </div>
@endsection
