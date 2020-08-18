@extends('supervisor.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <script type="text/javascript" language="javascript"
        src="{{ asset('bower_components/bower_package/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('bower_components/bower_package/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/supervisor_list_courses.css') }}" >
@endsection
@section('content')
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div class="d-flex flex fixed-content">
                <div class="d-flex flex fixed-content">
                    <div class="fade aside aside-sm" id="content-aside">
                        <div class="modal-dialog d-flex flex-column bg-body" id="user-nav">
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
                                                        data-toggle="pill" href="#all" role="tab">
                                                        <span class="nav-text">
                                                            {{ trans('supervisor.list_subjects.all') }}
                                                        </span>
                                                    </a>
                                                </li>
                                                @foreach ($courses as $course)
                                                    <div class="sidenav h-100 modal-dialog bg-light">
                                                        <div class="flex scrollable hover">
                                                            <div class="nav-active-text-primary" data-nav>
                                                                <ul class="nav ">
                                                                    <li>
                                                                        <a href="#">
                                                                            <a data-toggle="pill"
                                                                                href="{{ '#course' . $course->id }}" role="tab">
                                                                                <span class="nav-text">
                                                                                    {{ trans('supervisor.app.course') }}
                                                                                    {{ $course->id }}: {{ $course->title }}
                                                                                </span>
                                                                            </a>
                                                                        </a>
                                                                        <ul class="nav-sub nav-mega">
                                                                            @foreach ($course->subjects as $subject)
                                                                                @if ($subject->status == config('number.subject.active'))
                                                                                    <li>
                                                                                        <a data-toggle="pill"
                                                                                            href="{{ '#subject' . $subject->id }}" role="tab">
                                                                                            <span class="nav-text">
                                                                                                {{ $subject->title }}
                                                                                            </span>
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="page-content page-container" id="page-content">
                            <div class="padding">
                                <div class="table-responsive">
                                    <div id="datatable_wrapper"
                                        class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="tab-content" id="v-pills-tabContent">
                                                <div class="tab-pane fade show active" id="all"
                                                    role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                    <table id="example"
                                                        class="table table-theme table-row v-middle dataTable no-footer"
                                                        role="grid"
                                                        aria-describedby="datatable_info">
                                                        <thead>
                                                            <tr role="row">
                                                                <th class="column-width17" tabindex="0"
                                                                    aria-controls="datatable"
                                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                                    aria-label="ID: activate to sort column descending">
                                                                    <span class="text-muted">
                                                                        {{ trans('supervisor.list_subjects.id') }}
                                                                    </span>
                                                                </th>
                                                                <th class="column-width200" tabindex="0"
                                                                    aria-controls="datatable" rowspan="1" colspan="1"
                                                                    aria-label="Owner: activate to sort column ascending">
                                                                    <span class="text-muted">
                                                                        {{ trans('supervisor.list_tasks.created_at') }}
                                                                    </span>
                                                                </th>
                                                                <th class="column-width200" tabindex="0"
                                                                    aria-controls="datatable" rowspan="1" colspan="1"
                                                                    aria-label="Project: activate to sort column ascending">
                                                                    <span class="text-muted">
                                                                        {{ trans('supervisor.list_tasks.subject') }}
                                                                    </span>
                                                                </th>
                                                                <th class="column-width100" tabindex="0" rowspan="1"
                                                                    aria-controls="datatable" colspan="1" aria-label="Tasks">
                                                                    <span class="text-muted d-none d-sm-block">
                                                                        {{ trans('supervisor.list_tasks.trainee') }}
                                                                    </span>
                                                                </th>
                                                                <th class="column-width17" rowspan="1"
                                                                    colspan="1" aria-label="Tasks">
                                                                    <span class="text-muted d-none d-sm-block">
                                                                        {{ trans('supervisor.list_tasks.status') }}
                                                                    </span>
                                                                </th>
                                                                <th class="sorting_disabled column-width17"
                                                                    rowspan="1" colspan="1" aria-label="">
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($tasks as $index => $task)
                                                                <tr class="odd" data-id="1" role="row">
                                                                    <td class="sorting_1 column-id">
                                                                        <small class="text-muted">
                                                                            {{ $index + config('number.init')}}
                                                                        </small>
                                                                    </td>
                                                                    <td class="flex">
                                                                        <a href="#" class="item-title text-color ">
                                                                            {{ $task->created_at }}
                                                                        </a>
                                                                    </td>
                                                                    <td class="flex">
                                                                        <a href="#" class="item-title text-color ">
                                                                            {{ $task->subject->title }}
                                                                        </a>
                                                                    </td>
                                                                    <td class="flex">
                                                                        <a href="#" class="item-title text-color ">
                                                                            {{ $task->user->fullname }}
                                                                        </a>
                                                                    </td>
                                                                    <td class="flex">
                                                                        @if ($task->status == config('number.task.new'))
                                                                            <strong class="text-warning">
                                                                                {{ trans('supervisor.detail_task.new') }}
                                                                            </strong>
                                                                        @elseif ($task->status == config('number.task.passed'))
                                                                            <strong class="text-success">
                                                                                {{ trans('supervisor.detail_task.passed') }}
                                                                            </strong>
                                                                        @else
                                                                            <strong class="text-danger">
                                                                                {{ trans('supervisor.detail_task.failed') }}
                                                                            </strong>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('task.show', ['task' => $task->id]) }}">
                                                                            <i class="mx-2" data-feather="eye"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-5">
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <div class="dataTables_paginate paging_simple_numbers"
                                                                id="datatable_paginate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach ($courses as $course)
                                                    <div class="tab-pane fade show" id="{{ 'course' . $course->id }}"
                                                        role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                        <table id="datatable"
                                                            class="table table-theme table-row v-middle dataTable no-footer"
                                                            role="grid"
                                                            aria-describedby="datatable_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="column-width17" tabindex="0"
                                                                        aria-controls="datatable"
                                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                                        aria-label="ID: activate to sort column descending">
                                                                        <span class="text-muted">
                                                                            {{ trans('supervisor.list_subjects.id') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="column-width200" tabindex="0"
                                                                        aria-controls="datatable" rowspan="1" colspan="1"
                                                                        aria-label="Owner: activate to sort column ascending">
                                                                        <span class="text-muted">
                                                                            {{ trans('supervisor.list_tasks.created_at') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="column-width200" tabindex="0"
                                                                        aria-controls="datatable" rowspan="1" colspan="1"
                                                                        aria-label="Project: activate to sort column ascending">
                                                                        <span class="text-muted">
                                                                            {{ trans('supervisor.list_tasks.subject') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="column-width100" tabindex="0" rowspan="1"
                                                                        aria-controls="datatable" colspan="1" aria-label="Tasks">
                                                                        <span class="text-muted d-none d-sm-block">
                                                                            {{ trans('supervisor.list_tasks.trainee') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="column-width17" rowspan="1"
                                                                        colspan="1" aria-label="Tasks">
                                                                        <span class="text-muted d-none d-sm-block">
                                                                            {{ trans('supervisor.list_tasks.status') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="sorting_disabled column-width17"
                                                                        rowspan="1" colspan="1" aria-label="">
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($course->subjectTasks as $index => $task)
                                                                    <tr class="odd" data-id="1" role="row">
                                                                        <td class="sorting_1 column-id">
                                                                            <small class="text-muted">
                                                                                {{ $index + config('number.init') }}
                                                                            </small>
                                                                        </td>
                                                                        <td class="flex">
                                                                            <a href="#" class="item-title text-color ">
                                                                                {{ $task->created_at }}
                                                                            </a>
                                                                        </td>
                                                                        <td class="flex">
                                                                            <a href="#" class="item-title text-color ">
                                                                                {{ $task->subject->title }}
                                                                            </a>
                                                                        </td>
                                                                        <td class="flex">
                                                                            <a href="#" class="item-title text-color ">
                                                                                {{ $task->user->fullname }}
                                                                            </a>
                                                                        </td>
                                                                        <td class="flex">
                                                                            @if ($task->status == config('number.task.new'))
                                                                                <strong class="text-warning">
                                                                                    {{ trans('supervisor.detail_task.new') }}
                                                                                </strong>
                                                                            @elseif ($task->status == config('number.task.passed'))
                                                                                <strong class="text-success">
                                                                                    {{ trans('supervisor.detail_task.passed') }}
                                                                                </strong>
                                                                            @else
                                                                                <strong class="text-danger">
                                                                                    {{ trans('supervisor.detail_task.failed') }}
                                                                                </strong>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('task.show', ['task' => $task->id]) }}">
                                                                                <i class="mx-2" data-feather="eye"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @foreach ($course->subjects as $subject)
                                                        <div class="tab-pane fade show" id="{{ 'subject' . $subject->id }}"
                                                            role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                            <table id="datatable"
                                                                class="table table-theme table-row v-middle dataTable no-footer"
                                                                role="grid"
                                                                aria-describedby="datatable_info">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th class="column-width17" tabindex="0"
                                                                            aria-controls="datatable"
                                                                            rowspan="1" colspan="1" aria-sort="ascending"
                                                                            aria-label="ID: activate to sort column descending">
                                                                            <span class="text-muted">
                                                                                {{ trans('supervisor.list_subjects.id') }}
                                                                            </span>
                                                                        </th>
                                                                        <th class="column-width200" tabindex="0"
                                                                            aria-controls="datatable" rowspan="1" colspan="1"
                                                                            aria-label="Owner: activate to sort column ascending">
                                                                            <span class="text-muted">
                                                                                {{ trans('supervisor.list_tasks.created_at') }}
                                                                            </span>
                                                                        </th>
                                                                        <th class="column-width200" tabindex="0"
                                                                            aria-controls="datatable" rowspan="1" colspan="1"
                                                                            aria-label="Project: activate to sort column ascending">
                                                                            <span class="text-muted">
                                                                                {{ trans('supervisor.list_tasks.subject') }}
                                                                            </span>
                                                                        </th>
                                                                        <th class="column-width100" tabindex="0" rowspan="1"
                                                                            aria-controls="datatable" colspan="1" aria-label="Tasks">
                                                                            <span class="text-muted d-none d-sm-block">
                                                                                {{ trans('supervisor.list_tasks.trainee') }}
                                                                            </span>
                                                                        </th>
                                                                        <th class="column-width17" rowspan="1"
                                                                            colspan="1" aria-label="Tasks">
                                                                            <span class="text-muted d-none d-sm-block">
                                                                                {{ trans('supervisor.list_tasks.status') }}
                                                                            </span>
                                                                        </th>
                                                                        <th class="sorting_disabled column-width17"
                                                                            rowspan="1" colspan="1" aria-label="">
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($subject->tasks as $index => $task)
                                                                        <tr class="odd" data-id="1" role="row">
                                                                            <td class="sorting_1 column-id">
                                                                                <small class="text-muted">
                                                                                    {{ $index + config('number.init') }}
                                                                                </small>
                                                                            </td>
                                                                            <td class="flex">
                                                                                <a href="#" class="item-title text-color ">
                                                                                    {{ $task->created_at }}
                                                                                </a>
                                                                            </td>
                                                                            <td class="flex">
                                                                                <a href="#" class="item-title text-color ">
                                                                                    {{ $task->subject->title }}
                                                                                </a>
                                                                            </td>
                                                                            <td class="flex">
                                                                                <a href="#" class="item-title text-color ">
                                                                                    {{ $task->user->fullname }}
                                                                                </a>
                                                                            </td>
                                                                            <td class="flex">
                                                                                @if ($task->status == config('number.task.new'))
                                                                                    <strong class="text-warning">
                                                                                        {{ trans('supervisor.detail_task.new') }}
                                                                                    </strong>
                                                                                @elseif ($task->status == config('number.task.passed'))
                                                                                    <strong class="text-success">
                                                                                        {{ trans('supervisor.detail_task.passed') }}
                                                                                    </strong>
                                                                                @else
                                                                                    <strong class="text-danger">
                                                                                        {{ trans('supervisor.detail_task.failed') }}
                                                                                    </strong>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{ route('task.show', ['task' => $task->id]) }}">
                                                                                    <i class="mx-2" data-feather="eye"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endforeach
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
@endsection
@section('js')
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script
        src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
@endsection
