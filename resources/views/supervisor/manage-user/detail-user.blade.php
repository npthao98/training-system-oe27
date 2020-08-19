@extends('supervisor.layouts.app')
@section('css')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/samples/js/sample.js') }}"></script>
    <script src="{{ asset('js/message.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_course.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_detail_user.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/message.css') }}">
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
                    <div class="padding d-flex">
                        <div class="page-title">
                            <h2 class="text-md text-highlight">
                                {{ trans('trainee.detail_member.detail_member') }} -
                                @if ($user->status == config('number.user.active'))
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
                                    <img src="{{ asset(config('image.folder') . $user->avatar) }}"
                                        class="avatar">
                                </a>
                            </div>
                            <div class="px-sm-4 my-3 my-sm-0 flex">
                                <h2 class="text-md">
                                    {{ $user->fullname }}
                                </h2>
                                <strong class="d-block text-fade text-primary">
                                    ~ {{ $user->role->name }} ~
                                </strong>
                                <br>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.email') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.birthday') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        {{ $user->birthday }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.gender') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10">
                                        {{ $user->gender }}
                                    </div>
                                </div>
                                @if ($user->role_id == config('number.role.trainee'))
                                    <div class="timeline p-4 block mb-4">
                                        <h6>{{ trans('supervisor.detail_user.course_inactive') }}</h6>
                                        <table id="datatable"
                                            class="table table-theme table-row v-middle dataTable no-footer"
                                            role="grid"
                                            aria-describedby="datatable_info">
                                            <thead>
                                                <tr role="row">
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
                                                    <th class="sorting_disabled column-width17" rowspan="1"
                                                        colspan="1" aria-label="">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($coursesInActive as $course)
                                                    <tr class="odd" data-id="1" role="row">
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
                                                            <div class="item-action dropdown">
                                                                @if ($courseActive->isEmpty())
                                                                    <button type="submit" class="btn btn-primary"
                                                                        data-toggle="modal"
                                                                        data-target="#course{{ $course->id }}">
                                                                        {{ trans('supervisor.detail_user.active') }}
                                                                    </button>
                                                                @else
                                                                    <button disabled class="btn btn-primary">
                                                                        {{ trans('supervisor.detail_user.active') }}
                                                                    </button>
                                                                @endif
                                                                <div class="container">
                                                                    <div class="modal fade" id="course{{ $course->id }}" role="dialog">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="row">
                                                                                <div class="col-md-2"></div>
                                                                                <div class="col-md-8">
                                                                                    <div class="modal-content box-shadow mb-4">
                                                                                        <div class="modal-header">
                                                                                            <h5>
                                                                                                {{ trans('supervisor.app.course') }}:
                                                                                                {{ $course->title }}
                                                                                            </h5>
                                                                                            <button class="close" data-dismiss="modal">&times;</button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <p>
                                                                                                {{ trans('supervisor.app.message_active_course') }}
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button class="btn btn-light" data-dismiss="modal">
                                                                                                {{ trans('both.cancel') }}
                                                                                            </button>
                                                                                            <form action="{{ route('trainee.course.active',
                                                                                                ['trainee' => $user->id, 'course' => $course->id]) }}"
                                                                                                method="POST">
                                                                                                @method('PUT')
                                                                                                @csrf
                                                                                                <button type="submit" class="btn btn-primary">
                                                                                                    {{ trans('supervisor.detail_user.active') }}
                                                                                                </button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
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
                                    <div class="timeline p-4 block mb-4">
                                        <h6>{{ trans('supervisor.detail_user.progress') }}</h6>
                                        @foreach ($coursesProgress as $course)
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
                                            @foreach ($subjectsProgress as $subject)
                                                @if ($subject->course_id == $course->id)
                                                    <div class="tl-item">
                                                        <div class="tl-dot">
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
                                @endif
                            </div>
                        </div>
                        <br>
                        @if ($user->role_id == config('number.role.supervisor'))
                            <div class="d-flex justify-content-center">
                                <a href="{{ url()->previous() }}"
                                    class="btn w-sm mb-1 btn-info">
                                    {{ trans('trainee.detail_member.back') }}
                                </a>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-3"></div>
                                <div class="col-2 d-flex justify-content-center">
                                    <a href="{{ url()->previous() }}"
                                        class="btn w-sm mb-1 btn-info">
                                        {{ trans('trainee.detail_member.back') }}
                                    </a>
                                </div>
                                <div class="col-2 d-flex justify-content-center">
                                    <button class="btn w-sm mb-1 btn-warning"
                                        data-toggle="modal" data-target="#reset">
                                        {{ trans('supervisor.detail_user.reset_password') }}
                                    </button>
                                </div>
                                <div class="col-2 d-flex justify-content-center">
                                    <button class="btn w-sm mb-1 red"
                                        data-toggle="modal" data-target="#lock">
                                        @if ($user->status == config('number.user.active'))
                                            {{ trans('supervisor.detail_user.lock_account') }}
                                        @else
                                            {{ trans('supervisor.detail_user.unlock_account') }}
                                        @endif
                                    </button>
                                </div>
                                <div class="col-3"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="modal fade" id="lock" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="modal-content box-shadow mb-4">
                            <div class="modal-header">
                                <h5>{{ trans('supervisor.app.notification') }}</h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    @if ($user->status == config('number.user.active'))
                                        {{ trans('supervisor.detail_user.message_lock') }}
                                    @else
                                        {{ trans('supervisor.detail_user.message_unlock') }}
                                    @endif
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" data-dismiss="modal">
                                    {{ trans('both.cancel') }}
                                </button>
                                <form id="logout-form"
                                    action="{{ route('trainee.destroy', ['trainee' => $user->id]) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" data-toggle="modal" data-target="#delete"
                                        class="btn btn-danger">
                                        @if ($user->status == config('number.user.active'))
                                            {{ trans('supervisor.detail_user.lock_account') }}
                                        @else
                                            {{ trans('supervisor.detail_user.unlock_account') }}
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="modal fade" id="reset" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="modal-content box-shadow mb-4">
                            <div class="modal-header">
                                <h5>{{ trans('supervisor.app.notification') }}</h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    {{ trans('supervisor.detail_user.message_reset') }}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" data-dismiss="modal">
                                    {{ trans('both.cancel') }}
                                </button>
                                <form id="logout-form"
                                    action="{{ route('trainee.update', ['trainee' => $user->id]) }}"
                                    method="POST">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" data-toggle="modal" data-target="#delete"
                                        class="btn btn-primary">
                                        {{ trans('supervisor.detail_user.reset_password') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
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
