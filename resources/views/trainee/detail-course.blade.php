@extends('trainee.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
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
                            <img src="{{ asset('images/download.png') }}"
                                alt="{{ trans('trainee.detail_course.alt_image') }}">
                        </div>
                        <br>
                        <div>
                            {{--description--}}
                        </div>
                    </div>
                    <div id="accordion" class="mb-4 padding">
                        <div class="card mb-1">
                            <div class="card-header no-border" id="headingOne">
                                <a href="#" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="false" aria-controls="collapseOne">
                                    {{ trans('trainee.detail_course.list_subjects') }}
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item list-group-item-action">
                                            <a href="#">
                                                {{--subject--}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header no-border" id="headingTwo">
                                    <a href="#" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">
                                        {{ trans('trainee.detail_course.list_trainees') }}
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item list-group-item-action">
                                                <a href="#">
                                                    {{--Trainee--}}
                                                </a>
                                            </li>
                                            <li class="list-group-item list-group-item-action">
                                                <a href="#">
                                                    {{--Trainee--}}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
