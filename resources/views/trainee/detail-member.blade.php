@extends('trainee.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_course.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_user.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/trainee_detail_subject.css') }}">
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
@endsection
@section('content')
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div>
                <div class="page-hero page-container " id="page-hero">
                    <div class="padding d-flex">
                        <div class="page-title">
                            <h2 class="text-md text-highlight">
                                {{ trans('trainee.detail_member.detail_member') }} -
                                @if ($trainee->status == config('number.user.active'))
                                    <strong class="text-success">
                                        {{ trans('supervisor.detail_user.active') }}
                                    </strong>
                                @else
                                    <strong class="text-danger">
                                        {{ trans('supervisor.detail_user.inactive') }}
                                    </strong>
                                @endif
                            </h2>
                        </div>
                    </div>
                    <div>
                        <div class="p-4 d-sm-flex no-shrink b-b">
                            <div>
                                <a href="#" class="avatar w-96" data-pjax-state="">
                                    <img src="{{ asset(config('image.folder') . $trainee->avatar) }}"
                                        class="avatar">
                                </a>
                            </div>
                            <div class="px-sm-4 my-3 my-sm-0 flex">
                                <h2 class="text-md">
                                    {{ $trainee->fullname }}
                                </h2>
                                <strong class="d-block text-fade text-primary">
                                    ~ {{ $trainee->role->name }} ~
                                </strong>
                                <br>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.email') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ $trainee->email }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.birthday') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ $trainee->birthday }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.gender') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ $trainee->gender }}" disabled>
                                    </div>
                                </div>
                                <div class="timeline p-4 block mb-4">
                                    <h6>{{ trans('supervisor.detail_user.progress') }}</h6>
                                    @foreach ($courses as $course)
                                        <div class="tl-item  active">
                                            <div class="tl-dot ">
                                            </div>
                                            <div class="tl-date text-muted">
                                                {{ $course->pivot->start_time }}
                                            </div>
                                            <div class="tl-content">
                                                <div class="text-info">
                                                    <strong>
                                                        {{ $course->title }}
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($subjects as $subject)
                                            @if ($subject->course_id == $course->id)
                                                <div class="tl-item  ">
                                                    <div class="tl-dot ">
                                                    </div>
                                                    <div class="tl-date text-muted">
                                                        @if ($subject->pivot->status == config('number.active'))
                                                            <div class="text-success">
                                                                {{ $subject->pivot->start_time }}
                                                            </div>
                                                        @else
                                                            <div>
                                                                {{ $subject->pivot->start_time }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="tl-content">
                                                        @if ($subject->pivot->status == config('number.active'))
                                                            <div class="text-success">
                                                                {{ $subject->title }}
                                                            </div>
                                                        @else
                                                            <div>
                                                                {{ $subject->title }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <a href="{{ url()->previous()  }}"
                                class="btn w-sm mb-1 btn-info">
                                {{ trans('trainee.detail_member.back') }}
                            </a>
                        </div>
                    </div>
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
