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
    <script src="{{ asset('bower_components/bower_package/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bower_package/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <script type="text/javascript" language="javascript"
        src="{{ asset('bower_components/bower_package/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" language="javascript"
        src="{{ asset('bower_components/bower_package/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/message.css') }}">
@endsection
@section('content')
    @if (session('messenger'))
        <div id="messenger" class="alert alert-success" role="alert">
            <i data-feather="check"></i>
            <span class="mx-2">{{ session('messenger') }}</span>
        </div>
    @endif
    <div id="main" class="layout-column flex mb-5">
        <div id="content" class="flex ">
            <div>
                <div class="page-hero page-container " id="page-hero">
                    <div class="padding">
                        <div class="page-title">
                            <h2 class="text-md text-highlight">
                                {{ trans('supervisor.detail_course.detail_course') }}
                                <button class="btn w-sm btn-outline-success float-right"
                                    data-toggle="modal" data-target="#myModal">
                                    {{ trans('supervisor.list_trainees.assign') }}
                                </button>
                            </h2>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <h1>
                            {{ $course->title }}
                        </h1>
                    </div>
                    <div class="padding">
                        <br>
                        <div>
                            {!! $course->description !!}
                        </div>
                    </div>
                    <div id="accordion" class="mb-4 padding">
                        <div class="card mb-1">
                            <div class="card-header no-border" id="headingOne">
                                <h4>
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
                                                <a href="{{ route('subject.show', ['subject' => $subject->id]) }}"
                                                    class="link">
                                                    <span class="nav-text">
                                                        {{ $subject->title }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header no-border" id="headingTwo">
                                <h4>
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
                                        @foreach ($course->courseUsers as $courseUser)
                                            <li class="list-group-item">
                                                <a href="{{ route('trainee.show', ['trainee' => $courseUser->user_id]) }}"
                                                    class="link">
                                                    <span class="nav-text">
                                                        {{ $courseUser->user->fullname }}
                                                    </span>
                                                </a>
                                                @if ($courseUser->status == config('number.active'))
                                                    <span class="badge badge-info">
                                                        {{ trans('both.status.active') }}
                                                    </span>
                                                @elseif ($courseUser->status == config('number.inactive'))
                                                    <span class="badge badge-warning">
                                                        {{ trans('both.status.inactive') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-success">
                                                        {{ trans('both.status.passed') }}
                                                    </span>
                                                @endif
                                                <div class="item-action dropdown float-right">
                                                    @if ($courseUser->user->courseActive->isEmpty()
                                                        && $courseUser->status == config('number.inactive'))
                                                        <button type="submit" class="btn btn-primary"
                                                            data-toggle="modal"
                                                            data-target="#course{{ $courseUser->id }}">
                                                            {{ trans('supervisor.detail_user.active') }}
                                                        </button>
                                                    @else
                                                        <button disabled class="btn btn-primary">
                                                            {{ trans('supervisor.detail_user.active') }}
                                                        </button>
                                                    @endif
                                                    <div class="container">
                                                        <div class="modal fade" id="course{{ $courseUser->id }}" role="dialog">
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
                                                                                    ['trainee' => $courseUser->user_id, 'course' => $course->id]) }}"
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
                        class="btn w-sm mb-1 btn-danger">
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
                                <h5 class="modal-title">
                                    {{ trans('supervisor.app.message') }}
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
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('course.assign', ['course' => $course->id]) }}" method="post">
        @csrf
        <div class="container">
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-center border">
                            <h1 class="modal-title w-100 color_light">
                                {{ trans('supervisor.assign.assign') }}
                            </h1>
                            <button type="button" class="close"
                                data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="padding">
                            <input type="hidden" id="idOfHiddenInput" name="users">
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>
                                            {{ trans('supervisor.list_trainees.fullname') }}
                                        </th>
                                        <th>
                                            {{ trans('supervisor.list_trainees.email') }}
                                        </th>
                                        <th>
                                            {{ trans('supervisor.detail_user.birthday') }}
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <input class="checkbox-class" id="{{ $user->id }}"
                                                    type="checkbox" value="{{ $user->id }}">
                                            </td>
                                            <td>{{ $user->fullname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->birthday }}</td>
                                            <td>
                                                <a href="{{ route('trainee.show', ['trainee' => $user->id]) }}">
                                                    {{ trans('both.detail') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="padding d-flex justify-content-center">
                            <input type="submit" class="btn btn-info w-sm"
                                value="{{ trans('both.submit') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script src="{{ asset('js/assign_trainee.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}"></script>
@endsection
