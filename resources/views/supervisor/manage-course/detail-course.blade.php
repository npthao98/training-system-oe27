@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_course.css') }}">
@endsection
@section('content')
    <div id="main" class="layout-column flex mb-5">
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
                            {{ $course->title }}
                        </h1>
                    </div>
                    <div class="padding">
                        <div class="d-flex justify-content-center padding">
                            <img src="{{ asset(config('image.folder') . $course->image) }}"
                                alt="{{ trans('both.image_of_course') }}"
                                class="w-50">
                        </div>
                        <br>
                        <div>
                            {{ $course->description }}
                        </div>
                    </div>
                    <div id="accordion" class="mb-4 padding">
                        <div class="card mb-1">
                            <div class="card-header no-border" id="headingOne">
                                <h4>
                                    <span><i data-feather='arrow-right'></i></span>
                                    <span>
                                        <a href="#" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne">
                                            {{ trans('supervisor.detail_course.list_subjects') }}
                                        </a>
                                    </span>
                                    <span class="badge badge-success float-right">
                                        {{ count($course->subjects) }}
                                    </span>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($course->subjects as $subject)
                                            <li class="list-group-item">
                                                <a href="{{ route('subject.show', ['subject' => $subject->id]) }}" class="link">
                                            <span class="nav-text">
                                                {{ $subject->title }}
                                            </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header no-border" id="headingTwo">
                                    <h4>
                                        <span><i data-feather='arrow-right'></i></span>
                                        <span>
                                        <a href="#" data-toggle="collapse" data-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                        {{ trans('trainee.detail_course.list_trainees') }}
                                    </a>
                                    </span>
                                        <span class="badge badge-success float-right">
                                        {{ count($course->users) }}
                                    </span>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($course->users as $user)
                                                <li class="list-group-item">
                                                    <a href="{{ route('trainee.show', ['trainee' => $user->id]) }}" class="link">
                                                        <span class="nav-text">
                                                            {{ $user->fullname }}
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-2 d-flex justify-content-center">
                    <a href="{{ url()->previous() }}"
                        class="btn w-sm mb-1 btn-info">
                        {{ trans('both.back') }}
                    </a>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <button type="submit" data-toggle="modal" data-target="#delete"
                        class="btn w-sm mb-1 red">
                        {{ trans('both.delete') }}
                    </button>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <a href="{{ route('course.edit', ['course' => $course->id]) }}"
                        class="btn w-sm mb-1 btn-primary">
                        {{ trans('both.update') }}
                    </a>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="modal fade" id="delete" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="modal-content box-shadow mb-4">
                            <div class="modal-header">
                                <h5 class="modal-title">Message</h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    {{ trans('supervisor.detail_course.message_delete') }}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" data-dismiss="modal">
                                    {{ trans('both.cancel') }}
                                </button>
                                <form id="logout-form"
                                    action="{{ route('course.destroy', ['course' => $course->id]) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit"
                                        class="btn w-sm mb-1 red">
                                        {{ trans('both.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
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
@endsection
