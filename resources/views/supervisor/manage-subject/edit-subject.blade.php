@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
@endsection
@section('content')
    <form action="{{ route('subject.update', ['subject' => $subject->id]) }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="main" class="layout-column flex">
            <div id="content" class="flex ">
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">
                                    {{ trans('supervisor.edit_subject.edit_subject') }}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="page-content page-container" id="page-content">
                        <div class="padding">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>{{ trans('supervisor.create_subject.title') }}</strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title"
                                        value="{{ $subject->title }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>
                                        {{ trans('supervisor.create_subject.image') }}
                                    </strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>{{ trans('supervisor.create_subject.time') }}</strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="time"
                                        value="{{ $subject->time }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>
                                        {{ trans('supervisor.create_subject.course') }}
                                    </strong>
                                </label>
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <select class="form-control" name="course_id">
                                                @foreach ($courses as $course)
                                                    @if ($course->id == $subject->course_id)
                                                        <option value="{{ $course->id }}" selected>
                                                            {{ $course->title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $course->id }}">
                                                            {{ $course->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    <strong>
                                        {{ trans('supervisor.create_subject.description') }}
                                    </strong>
                                </label>
                                <div class="col-sm-12">
                                    <textarea name="content_description" required>{!! $subject->description !!}</textarea>
                                    @error ('content_description')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-center container">
                                <div class="col-3"></div>
                                <div class="col-3 d-flex justify-content-center">
                                    <a href="{{ url()->previous() }}" class="btn red">
                                        {{ trans('both.cancel') }}
                                    </a>
                                </div>
                                <div class="col-3 d-flex justify-content-center">
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
    <script src="{{ asset('js/ckeditor.js') }}"></script>
@endsection
