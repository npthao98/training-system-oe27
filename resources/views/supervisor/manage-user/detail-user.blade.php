@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_course.css') }}">
    link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_user.css') }}">
@endsection
@section('content')
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div>
                <div class="page-hero page-container " id="page-hero">
                    <div class="padding d-flex">
                        <div class="page-title">
                            <h2 class="text-md text-highlight">
                                {{ trans('supervisor.detail_user.detail_trainee') }}
                                -
                                @if (true) {{--role = user--}}
                                    <strong class="text-success">{{ trans('supervisor.detail_user.active') }}</strong>
                                @else {{--role = supervisor--}}
                                    <strong class="text-danger">{{ trans('supervisor.detail_user.inactive') }}</strong>
                                @endif
                            </h2>
                        </div>
                    </div>
                    <div>
                        <div class="p-4 d-sm-flex no-shrink b-b">
                            <div>
                                <a href="#" class="avatar w-96" data-pjax-state="">
                                    <img src="{{ asset('images/download.png') }}" alt="." class="avatar">
                                </a>
                            </div>
                            <div class="px-sm-4 my-3 my-sm-0 flex">
                                <h2 class="text-md">
                                    {{--fullname--}}
                                </h2>
                                <strong class="d-block text-fade text-primary">~ {{--role--}} ~</strong>
                                <br>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>{{ trans('supervisor.detail_user.email') }}: </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>{{ trans('supervisor.detail_user.birthday') }}: </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>{{ trans('supervisor.detail_user.gender') }}: </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="timeline p-4 block mb-4">
                                    <h6>{{ trans('supervisor.detail_user.progress') }}</h6>
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
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-3 d-flex justify-content-center">
                                <button class="btn w-sm mb-1 btn-warning">
                                    {{ trans('supervisor.detail_user.reset_password') }}
                                </button>
                            </div>
                            <div class="col-3 d-flex justify-content-center">
                                <button class="btn w-sm mb-1 red">
                                    {{ trans('supervisor.detail_user.lock_account') }}
                                </button>
                            </div>
                            <div class="col-3"></div>
                        </div>
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
