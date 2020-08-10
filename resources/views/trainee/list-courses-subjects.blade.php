@extends('trainee.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_list_courses.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/trainee_detail_subject.css') }}">
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
@endsection
@section('content')
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div class="d-flex flex fixed-content">
                <div class="d-flex flex fixed-content">
                    <div class="fade aside aside-sm" id="content-aside">
                        <div class="modal-dialog d-flex flex-column w-md bg-body" id="user-nav">
                            <div class="navbar">
                                <span class="text-md mx-2">
                                    {{ trans('supervisor.list_subjects.group') }}
                                </span>
                            </div>
                            <div class="scrollable hover">
                                <div class="sidenav p-2">
                                    <nav class="nav-active-text-primary" data-nav>
                                        <div class="nav flex-column nav-pills" id="v-pills-tab"
                                            role="tablist" aria-orientation="vertical">
                                            <ul class="nav">
                                                <li>
                                                    <a class="nav-link active bg-light"
                                                        data-toggle="pill" href="#active" role="tab">
                                                        <span class="nav-text">
                                                            {{ trans('trainee.app.active') }}
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link active bg-light"
                                                        data-toggle="pill" href="#passed" role="tab">
                                                        <span class="nav-text">
                                                            {{ trans('trainee.app.passed') }}
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link active bg-light"
                                                        data-toggle="pill" href="#inactive" role="tab">
                                                        <span class="nav-text">
                                                            {{ trans('trainee.app.inactive') }}
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="page-content page-container" id="page-content">
                            <div class="padding">
                                <div class="table-responsive">
                                    <div id="datatable_wrapper"
                                        class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="tab-content w-100" id="v-pills-tabContent">
                                                <div class="tab-pane fade show active" id="active"
                                                    role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                    <div id="accordion" class="mb-4 padding">
                                                        @foreach ($courseUsers as $courseUser)
                                                            @if ($courseUser->status == config('number.active'))
                                                                <div class="card mb-1">
                                                                    <div class="card-header no-border" id="headingOne">
                                                                        <a href="#" data-toggle="collapse"
                                                                            data-target="#collapse{{ $courseUser->course->id }}"
                                                                            aria-expanded="false" aria-controls="collapseOne">
                                                                            {{ trans('trainee.app.course') }}
                                                                            {{ $courseUser->course->id }}:
                                                                            {{ $courseUser->course->title }}
                                                                            <span>
                                                                                <a href="{{ route('course.show', ['course' => $courseUser->course->id]) }}"
                                                                                    class="float-right">
                                                                                    <i data-feather="chevrons-right"></i>
                                                                                </a>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <div id="collapse{{ $courseUser->course->id }}"
                                                                        class="collapse" aria-labelledby="headingOne"
                                                                        data-parent="#accordion">
                                                                        <div class="card-body">
                                                                            <ul class="list-group list-group-flush">
                                                                                @foreach ($courseUser->course->subjects as $subject)
                                                                                    <li class="list-group-item list-group-item-action">
                                                                                        <a href="{{ route('subject.show', ['subject' => $subject->id]) }}">
                                                                                            {{ $subject->title }}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade show" id="passed"
                                                    role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                    <div id="accordion" class="mb-4 padding">
                                                        @foreach ($courseUsers as $courseUser)
                                                            @if ($courseUser->status == config('number.passed'))
                                                                <div class="card mb-1">
                                                                    <div class="card-header no-border w-100" id="headingOne">
                                                                        <a href="#" data-toggle="collapse"
                                                                            data-target="#collapse{{ $courseUser->course->id }}"
                                                                            aria-expanded="false" aria-controls="collapseOne">
                                                                            {{ trans('trainee.app.course') }}
                                                                            {{ $courseUser->course->id }}:
                                                                            {{ $courseUser->course->title }}
                                                                            <span>
                                                                                <a href="{{ route('course.show', ['course' => $courseUser->course->id]) }}"
                                                                                    class="float-right">
                                                                                    <i data-feather="chevrons-right"></i>
                                                                                </a>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <div id="collapse{{ $courseUser->course->id }}" class="collapse"
                                                                        aria-labelledby="headingOne" data-parent="#accordion">
                                                                        <div class="card-body">
                                                                            <ul class="list-group list-group-flush">
                                                                                @foreach ($courseUser->course->subjects as $subject)
                                                                                    <li class="list-group-item list-group-item-action">
                                                                                        <a href="{{ route('subject.show', ['subject' => $subject->id]) }}">
                                                                                            {{ $subject->title }}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade show" id="inactive"
                                                    role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                    <div id="accordion" class="mb-4 padding">
                                                        @foreach ($courseUsers as $courseUser)
                                                            @if ($courseUser->status == config('number.inactive'))
                                                                <div class="card mb-1">
                                                                    <div class="card-header no-border" id="headingOne">
                                                                        <a href="#" data-toggle="collapse"
                                                                            data-target="#collapse{{ $courseUser->course->id }}"
                                                                            aria-expanded="false" aria-controls="collapseOne">
                                                                            {{ trans('trainee.app.course') }}
                                                                            {{ $courseUser->course->id }}:
                                                                            {{ $courseUser->course->title }}
                                                                            <span>
                                                                                <a href="{{ route('course.show', ['course' => $courseUser->course->id]) }}"
                                                                                    class="float-right">
                                                                                    <i data-feather="chevrons-right"></i>
                                                                                </a>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <div id="collapse{{ $courseUser->course->id }}" class="collapse"
                                                                        aria-labelledby="headingOne" data-parent="#accordion">
                                                                        <div class="card-body">
                                                                            <ul class="list-group list-group-flush">
                                                                                @foreach ($courseUser->course->subjects as $subject)
                                                                                    <li class="list-group-item list-group-item-action">
                                                                                        <a href="{{ route('subject.show', ['subject' => $subject->id]) }}">
                                                                                            {{ $subject->title }}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
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
    <script src="{{ asset('bower_components/bower_package/datatables/media/js/jquery.dataTables.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_package/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/datatable.js') }}">
    </script>
@endsection
