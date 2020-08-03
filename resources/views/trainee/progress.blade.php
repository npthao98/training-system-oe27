@extends('trainee.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_course.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_user.css') }}">
@endsection
@section('content')
    <div id="main" class="layout-column flex padding">
        <h2 class="">{{ trans('supervisor.detail_user.progress') }}</h2>
        <div class="tl-item  active">
            <div class="tl-dot ">
            </div>
            <div class="tl-date text-muted">
                {{--datetime--}}
            </div>
            <div class="tl-content">
                <div class="">
                    {{--content--}}
                </div>
            </div>
        </div>
        <div class="tl-item  ">
            <div class="tl-dot ">
            </div>
            <div class="tl-date text-muted">{{--datetime--}}</div>
            <div class="tl-content">
                <div class="">{{--content--}}</div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}">
    </script>
@endsection
