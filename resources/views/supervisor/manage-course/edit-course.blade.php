@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
@endsection
@section('content')
    <form action="#" method="post">
        @csrf
        <div id="main" class="layout-column flex">
            <div id="content" class="flex ">
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">
                                    {{ trans('supervisor.edit_course.edit_course') }}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="page-content page-container" id="page-content">
                        <div class="padding">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>{{ trans('supervisor.edit_course.title') }}</strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>{{ trans('supervisor.edit_course.image') }}</strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    <strong>{{ trans('supervisor.edit_course.description') }}</strong>
                                </label>
                                <div class="col-sm-12">
                                    <textarea name="ten" name="description"></textarea>
                                    <script>CKEDITOR.replace('ten');</script>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center container">
                                <div class="col-3"></div>
                                <div class="col-3 justify-content-center d-flex">
                                    <a href="{{ url()->previous() }}" class="btn red">
                                        {{ trans('both.cancel') }}
                                    </a>
                                </div>
                                <div class="col-3 justify-content-center d-flex">
                                    <button type="submit" class="btn btn-info">
                                        {{ trans('supervisor.create_subject.submit') }}
                                    </button>
                                </div>
                                <div class="col-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/createSubject.js') }}"></script>
@endsection
