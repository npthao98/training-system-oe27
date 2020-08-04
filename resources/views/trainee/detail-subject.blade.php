@extends('trainee.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_course.css') }}">
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/trainee_detail_subject.css') }}">
@endsection
@section('content')
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div>
                <div class="page-hero page-container " id="page-hero">
                    <div class="padding">
                        <div class="page-title">
                            <h2 class="text-md text-highlight">
                                {{ trans('supervisor.detail_subject.detail_subject') }}
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
                        {{--Hiển thị khi trainee active subject--}}
                        <div class="d-flex justify-content-center padding">
                            <button type="button" class="btn w-sm mb-1 btn-outline-info"
                                data-toggle="modal" data-target="#myModal">
                                {{ trans('trainee.detail_subject.create_task') }}
                            </button>
                        </div>
                        <div id="accordion" class="mb-4">
                            <div class="card mb-1">
                                <div class="card-header no-border" id="headingOne">
                                    <a href="#" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="false" aria-controls="collapseOne">
                                        {{ trans('trainee.detail_subject.list_tasks') }}
                                    </a>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item list-group-item-action">
                                                <a href="#" data-toggle="modal" data-target="#task">
                                                    {{-- task--}}
                                                    {{ trans('trainee.detail_subject.task') }}
                                                </a>
                                            </li>
                                            <div class="container">
                                                <div class="modal fade" id="task" role="dialog">
                                                    <div class="modal-dialog" role="document"x>
                                                        <div class="modal-content">
                                                            <div class="modal-header text-center border bg-info">
                                                                <h4 class="modal-title w-100 color_light">
                                                                    {{ trans('trainee.detail_subject.task') }}
                                                                    {{--Mã Task--}}
                                                                </h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="#" method="POST">
                                                                @csrf
                                                                <div class="modal-body mx-3">
                                                                    <label class="col-form-label">
                                                                        {{ trans('trainee.detail_subject.created_at') }}:
                                                                        {{--created at--}}-
                                                                        {{--if status = 0--}}
                                                                        <span class="text-warning">
                                                                            {{ trans('trainee.detail_subject.new') }}
                                                                        </span>
                                                                        {{--if status = 1--}}
                                                                        <span class="text-success">
                                                                            {{ trans('trainee.detail_subject.passed') }}
                                                                        </span>
                                                                        {{--if status = 2--}}
                                                                        <span class="text-danger">
                                                                            {{ trans('trainee.detail_subject.failed') }}
                                                                        </span>
                                                                    </label>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-12 col-form-label">
                                                                            {{ trans('trainee.detail_subject.review') }}
                                                                        </label>
                                                                        <div class="col-sm-12">
                                                                            <textarea class="form-control"
                                                                                rows="2" name="review">
                                                                                {{--review--}}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-12 col-form-label">
                                                                            {{ trans('trainee.detail_subject.plan') }}
                                                                        </label>
                                                                        <div class="col-sm-12">
                                                                            <textarea class="form-control"
                                                                                rows="3" name="plan">
                                                                                {{--plan--}}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-12 col-form-label">
                                                                            {{ trans('trainee.detail_subject.actual') }}
                                                                        </label>
                                                                        <div class="col-sm-12">
                                                                            <textarea class="form-control"
                                                                                rows="3" name="actual">
                                                                                {{--actual--}}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-12 col-form-label">
                                                                            {{ trans('trainee.detail_subject.next_plan') }}
                                                                        </label>
                                                                        <div class="col-sm-12">
                                                                            <textarea class="form-control"
                                                                                rows="3" name="next_plan">
                                                                                {{--next plan--}}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-12 col-form-label">
                                                                            {{ trans('trainee.detail_subject.comment') }}
                                                                        </label>
                                                                        <div class="col-sm-12">
                                                                            <textarea class="form-control"
                                                                                rows="2" name="comment">
                                                                                {{--comment--}}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-center">
                                                                    <button class="btn btn-info">
                                                                        {{ trans('trainee.detail_subject.update') }}
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    </div>
    <div class="container">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center border bg-info">
                        <h4 class="modal-title w-100 color_light">
                            {{ trans('trainee.detail_subject.task') }}
                        </h4>
                        <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="POST">
                        @csrf
                        <div class="modal-body mx-3">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    {{ trans('trainee.detail_subject.plan') }}
                                </label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3"
                                        placeholder="{{ trans('trainee.detail_subject.pla_plan') }}"
                                        name="plan"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    {{ trans('trainee.detail_subject.actual') }}
                                </label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3"
                                        placeholder="{{ trans('trainee.detail_subject.pla_actual') }}"
                                        name="actual"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    {{ trans('trainee.detail_subject.next_plan') }}
                                </label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="3"
                                        placeholder="{{ trans('trainee.detail_subject.pla_next_plan') }}"
                                        name="next_plan"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    {{ trans('trainee.detail_subject.comment') }}
                                </label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" rows="2"
                                        placeholder="{{ trans('trainee.detail_subject.pla_comment') }}"
                                        name="comment"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button class="btn btn-info">
                                {{ trans('trainee.detail_subject.submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
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
