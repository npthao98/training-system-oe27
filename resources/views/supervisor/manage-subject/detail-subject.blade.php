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
                                {{ trans('supervisor.detail_subject.detail_subject') }}
                            </h2>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <h1>
                            {{ $subject->title }}
                        </h1>
                    </div>
                    <div class="padding">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset(config('image.folder') . $subject->image) }}"
                                alt="{{ trans('both.image_of_subject') }}"
                                class="w-50">
                        </div>
                        <br>
                        <div>
                            {{ $subject->description }}
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
                                            {{ trans('supervisor.detail_subject.list_trainees') }}
                                        </a>
                                    </span>
                                    <span class="badge badge-success float-right">
                                        {{ count($subject->users) }}
                                    </span>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($subject->users as $user)
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
                            <div class="card mb-1">
                                <div class="card-header no-border" id="headingTwo">
                                    <h4>
                                        <span><i data-feather='arrow-right'></i></span>
                                        <span>
                                            <a href="#" data-toggle="collapse" data-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                {{ trans('supervisor.detail_subject.list_tasks') }}
                                            </a>
                                        </span>
                                        <span class="badge badge-success float-right">
                                            {{ count($tasks) }}
                                        </span>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($tasks as $task)
                                                <li class="list-group-item">
                                                    <a href="{{ route('task.show', ['task' => $task->id]) }}" class="link">
                                                        <span class="nav-text">
                                                            {{ trans('supervisor.app.task') . " " . $task->id . ": " }}
                                                            {{ $task->user->fullname }}
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
    </div>
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}"></script>
@endsection
