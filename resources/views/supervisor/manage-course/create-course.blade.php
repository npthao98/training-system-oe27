@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('css/supervisor_detail_course.css') }}">
@endsection
@section('content')
    <form action="{{ route('course.store') }}"
        method="post" enctype="multipart/form-data">
        @csrf
        <div id="main" class="layout-column flex">
            <div id="content" class="flex ">
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">
                                    {{ trans('supervisor.create_course.new_course') }}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="page-content page-container" id="page-content">
                        <div class="padding">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>
                                        {{ trans('supervisor.create_course.title') }}
                                    </strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        name="title" required value="{{ old('title') }}">
                                    @error ('title')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>
                                        {{ trans('supervisor.create_course.image') }}
                                    </strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control"
                                        name="image" required value="{{ old('image') }}">
                                    @error ('image')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    <strong>
                                        {{ trans('supervisor.create_course.description') }}
                                    </strong>
                                </label>
                                <div class="col-sm-12">
                                    <textarea name="content_description">{{ old('content_description') }}</textarea>
                                    @error ('content_description')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-5">
                                <label class="col-sm-2 col-form-label">
                                    <strong>
                                        {{ trans('supervisor.list_subjects.list_subjects') }}
                                    </strong>
                                </label>
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-outline-info"
                                        onclick="addItem()">
                                        {{ trans('supervisor.create_subject.new_subject') }}
                                    </button>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="mytable" class="table table-bordred table-striped">
                                                    <thead>
                                                        <th>
                                                            {{ trans('supervisor.app.subject') }}
                                                        </th>
                                                        <th>
                                                            {{ trans('supervisor.list_subjects.time') }}
                                                        </th>
                                                        <th>{{ trans('both.delete') }}</th>
                                                    </thead>
                                                    <tbody id="subjects">
                                                        <tr id="item0">
                                                            <td>
                                                                <input type="text" required name="titleSubject[]"
                                                                    class="border-0 w-100" value="{{ old('timeSubject[]') }}">
                                                                @error ('titleSubject[]')
                                                                    <div class="alert alert-danger">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="number" min="2" required name="timeSubject[]"
                                                                    class="border-0 w-100" value="{{ old('timeSubject[]') }}">
                                                                @error ('timeSubject[]')
                                                                    <div class="alert alert-danger">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <button class="btn red btn-xs" onclick="deleteItem(item0)">
                                                                    {{ trans('both.delete') }}
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-5">
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3 d-flex justify-content-center">
                                        <button type="submit" class="btn red">
                                            {{ trans('both.cancel') }}
                                        </button>
                                    </div>
                                    <div class="col-3 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ trans('supervisor.create_course.submit') }}
                                        </button>
                                    </div>
                                    <div class="col-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script src="{{ asset('js/add_subject.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
@endsection
