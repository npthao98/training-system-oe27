@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_course.css') }}">
@endsection
@section('content')
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div>
                <div class="page-hero page-container " id="page-hero">
                    <div class="padding d-flex">
                        <div class="page-title">
                            <h2 class="text-md text-highlight">
                                {{ trans('supervisor.detail_course.detail_course') }}
                            </h2>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <h1>
                            {{--title--}}
                        </h1>
                    </div>
                    <div class="padding">
                        <div>
                            <img src="{{ asset('images/download.png') }}" alt="image of course">
                        </div>
                        <br>
                        <div>
                            {{--description--}}
                        </div>
                    </div>
                    <div class="padding">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="#" class="link">
                                    <h4>
                                        <span><i data-feather='arrow-right'></i></span>
                                        <span>{{ trans('supervisor.detail_course.list_subjects') }}</span>
                                        <span class="badge badge-success float-right">
                                            {{--number subjects--}}
                                        </span>
                                    </h4>
                                </a>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="#" class="link">
                                            <span class="nav-text">
                                                {{--name subject--}}
                                            </span>
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" class="link">
                                            <span class="nav-text">
                                                {{--name subject--}}
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="link">
                                    <h4>
                                        <span><i data-feather='arrow-right'></i></span>
                                        <span>{{ trans('supervisor.detail_course.list_trainees') }}</span>
                                        <span class="badge badge-primary float-right">
                                            {{--number trainee--}}
                                        </span>
                                    </h4>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}"></script>
@endsection
