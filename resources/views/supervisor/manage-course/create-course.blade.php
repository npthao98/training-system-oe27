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
    <form action="#" method="post">
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
                                    <strong>{{ trans('supervisor.create_course.title') }}</strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>{{ trans('supervisor.create_course.image') }}</strong>
                                </label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    <strong>{{ trans('supervisor.create_course.description') }}</strong>
                                </label>
                                <div class="col-sm-12">
                                    <div class="adjoined-bottom">
                                        <div class="grid-container">
                                            <div class="grid-width-100">
                                                <input name="description" id="editor">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mt-5">
                                <label class="col-sm-2 col-form-label">
                                    <strong>{{ trans('supervisor.list_subjects.list_subjects') }}</strong>
                                </label>
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-outline-info"
                                        data-toggle="modal" data-target="#myModal">
                                        {{ trans('supervisor.create_subject.new_subject') }}
                                    </button>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="mytable" class="table table-bordred table-striped">
                                                    <thead>
                                                        <th>{{ trans('supervisor.list_subjects.list_subjects') }}</th>
                                                        <th>{{ trans('supervisor.list_subjects.time') }}</th>
                                                        <th>{{ trans('both.update') }}</th>
                                                        <th>{{ trans('both.delete') }}</th>
                                                    </thead>
                                                    <tbody id="subjects">
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="titleSubject" class="border-0 w-100" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="timeSubject" class="border-0 w-100" readonly>
                                                            </td>
                                                            <input type="hidden" name="imageSubject" class="border-0 w-100" readonly>
                                                            <input type="hidden" name="descriptionSubject" class="border-0 w-100" readonly>
                                                            <td>
                                                                <p data-placement="top" data-toggle="tooltip" title="Edit">
                                                                    <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" >
                                                                        <i class="mx-2" data-feather="edit"></i>
                                                                    </button>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p data-placement="top" data-toggle="tooltip" title="Delete">
                                                                    <button class="btn red btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" >
                                                                        <i class="mx-2" data-feather="trash-2"></i>
                                                                    </button>
                                                                </p>
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
    <div class="container">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center border">
                        <h4 class="modal-title w-100 color_light">
                            {{ trans('supervisor.create_subject.new_subject') }}
                        </h4>
                        <button type="button" class="close"
                                data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="post">
                        @csrf
                        <div id="main" class="layout-column flex">
                            <div id="content" class="flex ">
                                <div>
                                    <div class="page-content page-container" id="page-content">
                                        <div class="padding">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">
                                                    <strong>{{ trans('supervisor.create_subject.title') }}</strong>
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="title" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">
                                                    <strong>{{ trans('supervisor.create_subject.image') }}</strong>
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="file" class="form-control" id="image" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">
                                                    <strong>{{ trans('supervisor.create_subject.time') }}</strong>
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="time" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">
                                                    <strong>{{ trans('supervisor.create_subject.description') }}</strong>
                                                </label>
                                                <div class="col-sm-10">
                                                    <textarea rows="3" class="form-control" id="descrition" required>
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-info" data-dismiss="modal" onclick="add()">
                                                    {{ trans('supervisor.create_subject.submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/create_subject.js') }}"></script>
@endsection
