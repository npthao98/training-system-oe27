@extends('supervisor.layouts.app')
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
                                {{ trans('supervisor.detail_task.detail_task') }} -
                                @if (true) {{--status = 0--}}
                                    <strong class="text-warning">
                                        {{ trans('supervisor.detail_task.new') }}
                                    </strong>
                                @elseif (false) {{--status = 1--}}
                                    <strong class="text-success">
                                        {{ trans('supervisor.detail_task.passed') }}
                                    </strong>
                                @else {{--status = 2--}}
                                    <strong class="text-danger">
                                        {{ trans('supervisor.detail_task.failed') }}
                                    </strong>
                                @endif
                            </h2>
                        </div>
                    </div>
                    <div class="padding">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.date') }}: </strong>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.subject') }}: </strong>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.trainee') }}: </strong>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.plan') }}: </strong>
                            </label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.actual') }}: </strong>
                            </label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.next_plan') }}: </strong>
                            </label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.comment') }}: </strong>
                            </label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>
                                    {{ trans('supervisor.detail_task.review') }}:
                                </strong>
                            </label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-3 d-flex justify-content-center">
                                <button class="btn w-sm mb-1 red">
                                    {{ trans('supervisor.detail_task.fail') }}
                                </button>
                            </div>
                            <div class="col-3 d-flex justify-content-center">
                                <button class="btn w-sm mb-1 btn-success">
                                    {{ trans('supervisor.detail_task.pass') }}
                                </button>
                            </div>
                            <div class="col-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}"></script>
@endsection
