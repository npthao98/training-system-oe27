@extends('supervisor.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('bower_components/chart.js/dist/chart.min.css') }}">

@endsection
@section('content')
    <div class="padding">
        <div class="padding d-flex justify-content-center">
            <h3>{{ trans('supervisor.title_chart_trainees_by_course') }}</h3>
        </div>
        <canvas id="chart"></canvas>
    </div>
@endsection
@section('js')
    <script src="{{ asset('/bower_components/chart.js/dist/chart.min.js') }}"></script>
    <script src="{{ asset('js/chart_trainees_by_course.js') }}"></script>
@endsection
