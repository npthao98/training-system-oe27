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
    <link type="text/css" rel="stylesheet" href="{{ asset('css/progress.css') }}">
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
@endsection
@section('content')
    <div id="main" class="layout-column flex padding">
        <h2 class="">{{ trans('supervisor.detail_user.progress') }}</h2>
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
