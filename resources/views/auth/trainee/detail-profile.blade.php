@extends('trainee.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_list_courses.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/message.js') }}"></script>
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
                            <h1 class="text-highlight">
                                {{ trans('both.profile') }}
                            </h1>
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
                                <br>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.email') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10 mt-1">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.birthday') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10 mt-1">
                                        {{ $user->birthday }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        <strong>
                                            {{ trans('supervisor.detail_user.gender') }}:
                                        </strong>
                                    </label>
                                    <div class="col-sm-10 mt-1">
                                        {{ $user->gender }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-2 d-flex justify-content-center">
                                <a href="{{ url()->previous() }}"
                                    class="btn w-sm mb-1 btn-info">
                                    {{ trans('trainee.detail_member.back') }}
                                </a>
                            </div>
                            <div class="col-2 d-flex justify-content-center">
                                <a href="{{ route('user.edit.password') }}"
                                    class="btn w-sm mb-1 btn-primary">
                                    {{ trans('both.change_password') }}
                                </a>
                            </div>
                            <div class="col-2 d-flex justify-content-center">
                                <a href="{{ route('user.edit.profile') }}"
                                    class="btn w-sm mb-1 btn-secondary">
                                    {{ trans('both.update_profile') }}
                                </a>
                            </div>
                            <div class="col-3"></div>
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
