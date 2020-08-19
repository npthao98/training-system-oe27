@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('js/message.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_list_courses.css') }}">
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
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div>
                <div class="page-hero page-container " id="page-hero">
                    <div class="padding pb-0">
                        <div class="page-title mb-5">
                            <h2 class="text-md text-highlight">
                                {{ trans('supervisor.list_courses.list_courses') }}
                                <a href="{{ route('course.create') }}"
                                    class="btn btn-primary mt-2 float-right">
                                    {{ trans('supervisor.create_course.new_course') }}
                                </a>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="page-content page-container" id="page-content">
                    <div class="padding pt-0">
                        <div class="table-responsive">
                            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example"
                                            class="table table-theme table-row v-middle dataTable no-footer"
                                            role="grid"
                                            aria-describedby="datatable_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc column-width27" tabindex="0"
                                                        aria-controls="datatable" rowspan="1"
                                                        colspan="1" aria-sort="ascending"
                                                        aria-label="ID: activate to sort column descending">
                                                        <span class="text-muted">
                                                            {{ trans('supervisor.list_courses.id') }}
                                                        </span>
                                                    </th>
                                                    <th class="sorting column-width39" tabindex="0"
                                                        aria-controls="datatable" rowspan="1" colspan="1"
                                                        aria-label="Owner: activate to sort column ascending">
                                                        <span class="text-muted">
                                                            {{ trans('supervisor.list_courses.image') }}
                                                        </span>
                                                    </th>
                                                    <th class="sorting column-width768" tabindex="0"
                                                        aria-controls="datatable" rowspan="1" colspan="1"
                                                        aria-label="Project: activate to sort column ascending">
                                                        <span class="text-muted">
                                                            {{ trans('supervisor.list_courses.title') }}
                                                        </span>
                                                    </th>
                                                    <th class="sorting_disabled column-width34" rowspan="1"
                                                        colspan="1" aria-label="Tasks">
                                                        <span class="text-muted d-none d-sm-block">
                                                            {{ trans('supervisor.list_courses.subjects') }}
                                                        </span>
                                                    </th>
                                                    <th class="sorting_disabled column-width35" rowspan="1"
                                                        colspan="1" aria-label="Finish">
                                                        <span class="text-muted d-none d-sm-block">
                                                            {{ trans('supervisor.list_courses.attending') }}
                                                        </span>
                                                    </th>
                                                    <th class="sorting_disabled column-width17" rowspan="1"
                                                        colspan="1" aria-label="">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($courses as $index => $course)
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
                                                                        src="{{ asset(config('image.folder') . $course->image) }}"
                                                                        alt="{{ trans('both.image_of_course') }}">
                                                                </span>
                                                            </a>
                                                        </td>
                                                        <td class="flex">
                                                            <a href="#" class="item-title text-color ">
                                                                {{ $course->title }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm ">
                                                                {{ count($course->subjects) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                                {{ count($course->users) }}
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
                                                                        href="{{ route('course.show', ['course' => $course->id]) }}">
                                                                        {{ trans('supervisor.list_courses.see') }}
                                                                    </a>
                                                                    <a class="dropdown-item edit"
                                                                        href="{{ route('course.edit', ['course' => $course->id]) }}">
                                                                        {{ trans('supervisor.list_courses.edit') }}
                                                                    </a>
                                                                    <button type="submit"
                                                                        class="border-0 dropdown-item trash"
                                                                        data-toggle="modal" data-target="#delete{{ $course->id }}">
                                                                        {{ trans('supervisor.list_courses.delete') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <div class="container">
                                                        <div class="modal fade" id="delete{{ $course->id }}" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="row">
                                                                    <div class="col-md-1"></div>
                                                                    <div class="col-md-10">
                                                                        <div class="modal-content box-shadow mb-4">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">
                                                                                    {{ trans('supervisor.app.course') .
                                                                                        $course->id . ': ' . $course->title }}
                                                                                </h5>
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
                                                @endforeach
                                            </tbody>
                                        </table>
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
