@extends('supervisor.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_list_courses.css') }}">
@endsection
@section('content')
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div>
                <div class="page-hero page-container " id="page-hero">
                    <div class="padding pb-0">
                        <div class="page-title">
                            <h2 class="text-md text-highlight">{{ trans('supervisor.list_courses.list_courses') }}</h2>
                        </div>
                        <a href="{{ route('course.create') }}" class="btn btn-primary mt-2">
                            {{ trans('supervisor.create_course.new_course') }}
                        </a>
                    </div>
                </div>
                <div class="page-content page-container" id="page-content">
                    <div class="padding pt-0">
                        <div class="table-responsive">
                            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="datatable"
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
                                                @foreach ($courses as $course)
                                                    <tr class="odd" data-id="1" role="row">
                                                        <td class="sorting_1 column-id">
                                                            <small class="text-muted">
                                                                {{ $course->id }}
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
                                                                    <form id="logout-form"
                                                                        action="{{ route('course.destroy', ['course' => $course->id]) }}"
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
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                                            {{ $courses->links('pagination') }}
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
