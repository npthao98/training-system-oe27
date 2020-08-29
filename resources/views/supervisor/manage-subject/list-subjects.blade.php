@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('js/message.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supervisor_list_courses.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/message.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supervisor_list_courses.css') }}" >
    <script type="text/javascript" language="javascript"
        src="{{ asset('bower_components/bower_package/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('bower_components/bower_package/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
@endsection
@section('content')
    @if (session('messenger'))
        <div id="messenger" class="alert alert-success" role="alert">
            <i data-feather="check"></i>
            <span class="mx-2">{{ session('messenger') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div id="messenger" class="alert alert-danger" role="alert">
            <i data-feather="x"></i>
            <span class="mx-2">{{ session('error') }}</span>
        </div>
    @endif
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div class="d-flex flex fixed-content">
                <div class="d-flex flex fixed-content">
                    <div class="fade aside aside-sm" id="content-aside">
                        <div class="modal-dialog d-flex flex-column w-md bg-body" id="user-nav">
                            <div class="navbar">
                                <span class="text-md mx-2">{{ trans('supervisor.list_subjects.group') }}</span>
                                <a href="{{ route('subject.create') }}"
                                    class="float-right btn btn-primary mt-2">
                                    {{ trans('supervisor.create_subject.new_subject') }}
                                </a>
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
                                                        <span class="nav-badge">
                                                            <b class="badge badge-sm badge-pill gd-danger">
                                                                {{ count($subjects) }}
                                                            </b>
                                                        </span>
                                                    </a>
                                                </li>
                                                @foreach ($courses as $course)
                                                    <li>
                                                        <a class="nav-link" data-toggle="pill"
                                                            href="{{ '#course' . $course->id }}" role="tab">
                                                            <span class="nav-text">
                                                                {{ trans('supervisor.app.course') }}
                                                                {{ $course->id }}: {{ $course->title }}
                                                            </span>
                                                            <span class="nav-badge">
                                                                <b class="badge badge-sm badge-pill gd-success">
                                                                    {{ count($course->subjects) }}
                                                                </b>
                                                            </span>
                                                        </a>
                                                    </li>
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
                                                                <th class="sorting_asc column-width27" tabindex="0"
                                                                    aria-controls="datatable"
                                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                                    aria-label="ID: activate to sort column descending">
                                                                    <span class="text-muted">
                                                                        {{ trans('supervisor.list_subjects.id') }}
                                                                    </span>
                                                                </th>
                                                                <th class="sorting column-width39" tabindex="0"
                                                                    aria-controls="datatable" rowspan="1" colspan="1"
                                                                    aria-label="Owner: activate to sort column ascending">
                                                                    <span class="text-muted">
                                                                        {{ trans('supervisor.list_subjects.image') }}
                                                                    </span>
                                                                </th>
                                                                <th class="sorting column-width768" tabindex="0"
                                                                    aria-controls="datatable" rowspan="1" colspan="1"
                                                                    aria-label="Project: activate to sort column ascending">
                                                                    <span class="text-muted">
                                                                        {{ trans('supervisor.list_subjects.title') }}
                                                                    </span>
                                                                </th>
                                                                <th class="sorting column-width34" tabindex="0" rowspan="1"
                                                                    aria-controls="datatable" colspan="1" aria-label="Tasks">
                                                                    <span class="text-muted d-none d-sm-block">
                                                                        {{ trans('supervisor.list_subjects.time') }}
                                                                    </span>
                                                                </th>
                                                                <th class="sorting column-width34" rowspan="1"
                                                                    colspan="1" aria-label="Tasks">
                                                                    <span class="text-muted d-none d-sm-block">
                                                                        {{ trans('supervisor.list_subjects.course') }}
                                                                    </span>
                                                                </th>
                                                                <th class="sorting_disabled column-width17"
                                                                    rowspan="1" colspan="1" aria-label="">
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($subjects as $index => $subject)
                                                                <tr class="odd" data-id="1" role="row">
                                                                    <td class="sorting_1 column-id">
                                                                        <small class="text-muted">
                                                                            {{ $index + config('number.init') }}
                                                                        </small>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#">
                                                                        <span class="w-32 gd-primary">
                                                                            <img class="language-image"
                                                                                src="{{ asset(config('image.folder') . $subject->image) }}">
                                                                        </span>
                                                                        </a>
                                                                    </td>
                                                                    <td class="flex">
                                                                        <a href="#" class="item-title text-color ">
                                                                            {{ $subject->title }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <span class="item-amount d-none d-sm-block text-sm ">
                                                                            {{ $subject->time }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="item-amount d-none d-sm-block text-sm ">
                                                                            {{ $subject->course_id }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="item-action dropdown">
                                                                            <a href="#" data-toggle="dropdown"
                                                                                class="text-muted">
                                                                                <i class="mx-2" data-feather="more-vertical">
                                                                                </i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right bg-black"
                                                                                role="menu">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('subject.show', ['subject' => $subject->id]) }}">
                                                                                    {{ trans('supervisor.list_courses.see') }}
                                                                                </a>
                                                                                <a class="dropdown-item edit"
                                                                                    href="{{ route('subject.edit', ['subject' => $subject->id]) }}">
                                                                                    {{ trans('supervisor.list_courses.edit') }}
                                                                                </a>
                                                                                <button type="submit"
                                                                                    class="border-0 dropdown-item trash"
                                                                                    data-toggle="modal" data-target="#delete{{ $subject->id }}">
                                                                                    {{ trans('supervisor.list_courses.delete') }}
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <div class="container">
                                                                        <div class="modal fade" id="delete{{ $subject->id }}" role="dialog">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="row">
                                                                                    <div class="col-md-1"></div>
                                                                                    <div class="col-md-10">
                                                                                        <div class="modal-content box-shadow mb-4">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title">
                                                                                                    {{ trans('supervisor.app.subject') . ' ' .
                                                                                                        $subject->id . ': ' . $subject->title }}
                                                                                                </h5>
                                                                                                <button class="close" data-dismiss="modal">&times;</button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>
                                                                                                    {{ trans('supervisor.detail_subject.message_delete') }}
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button class="btn btn-light" data-dismiss="modal">
                                                                                                    {{ trans('both.cancel') }}
                                                                                                </button>
                                                                                                <form id="logout-form"
                                                                                                    action="{{ route('subject.destroy', ['subject' => $subject->id]) }}"
                                                                                                    method="POST">
                                                                                                    @method('DELETE')
                                                                                                    @csrf
                                                                                                    <button type="submit" data-toggle="modal" data-target="#delete"
                                                                                                        class="btn w-sm mb-1 btn-danger">
                                                                                                        {{ trans('both.delete') }}
                                                                                                    </button>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-1"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @foreach ($courses as $course)
                                                    <div class="tab-pane fade show" id="{{ 'course'.$course->id }}"
                                                        role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                        <table id="datatable"
                                                            class="table table-theme table-row v-middle dataTable no-footer"
                                                            role="grid"
                                                            aria-describedby="datatable_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting_asc column-width27" tabindex="0"
                                                                        aria-controls="datatable"
                                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                                        aria-label="ID: activate to sort column descending">
                                                                        <span class="text-muted">
                                                                            {{ trans('supervisor.list_subjects.id') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="sorting column-width39" tabindex="0"
                                                                        aria-controls="datatable" rowspan="1" colspan="1"
                                                                        aria-label="Owner: activate to sort column ascending">
                                                                        <span class="text-muted">
                                                                            {{ trans('supervisor.list_subjects.image') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="sorting column-width768" tabindex="0"
                                                                        aria-controls="datatable" rowspan="1" colspan="1"
                                                                        aria-label="Project: activate to sort column ascending">
                                                                        <span class="text-muted">
                                                                            {{ trans('supervisor.list_subjects.title') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="sorting column-width34" tabindex="0" rowspan="1"
                                                                        aria-controls="datatable" colspan="1" aria-label="Tasks">
                                                                        <span class="text-muted d-none d-sm-block">
                                                                            {{ trans('supervisor.list_subjects.time') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="sorting column-width34"
                                                                        rowspan="1" colspan="1" aria-label="Tasks">
                                                                        <span class="text-muted d-none d-sm-block">
                                                                            {{ trans('supervisor.list_subjects.course') }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="sorting_disabled column-width17"
                                                                        rowspan="1" colspan="1" aria-label="">
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($course->subjects as $index => $subject)
                                                                    <tr class="odd" data-id="1" role="row">
                                                                        <td class="sorting_1 column-id">
                                                                            <small class="text-muted">
                                                                                {{ $index + config('number.init') }}
                                                                            </small>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#">
                                                                                <span class="w-32 gd-primary">
                                                                                    <img class="language-image"
                                                                                        src="{{ asset(config('image.folder') . $subject->image) }}">
                                                                                </span>
                                                                            </a>
                                                                        </td>
                                                                        <td class="flex">
                                                                            <a href="#" class="item-title text-color ">
                                                                                {{ $subject->title }}
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <span class="item-amount d-none d-sm-block text-sm ">
                                                                                {{ $subject->time }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="item-amount d-none d-sm-block text-sm ">
                                                                                {{ $subject->course_id }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <div class="item-action dropdown">
                                                                                <a href="#" data-toggle="dropdown" class="text-muted">
                                                                                    <i class="mx-2" data-feather="more-vertical"></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right bg-black"
                                                                                    role="menu">
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('subject.show', ['subject' => $subject->id]) }}">
                                                                                        {{ trans('supervisor.list_courses.see') }}
                                                                                    </a>
                                                                                    <a class="dropdown-item edit"
                                                                                        href="{{ route('subject.edit', ['subject' => $subject->id]) }}">
                                                                                        {{ trans('supervisor.list_courses.edit') }}
                                                                                    </a>
                                                                                    <form id="logout-form"
                                                                                        action="{{ route('subject.destroy', ['subject' => $subject->id]) }}"
                                                                                        method="POST">
                                                                                        @method('DELETE')
                                                                                        @csrf
                                                                                        <button type="submit"
                                                                                            class="border-0 dropdown-item trash">
                                                                                            {{ trans('supervisor.list_courses.delete') }}
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
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
    <script src="{{ asset('bower_components/bower_package/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ asset('bower_components/bower_package/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/datatable.js') }}"></script>
@endsection
