@extends('trainee.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_list_courses.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/avatar.css') }}">
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
@endsection
@section('content')
    <div class="card padding">
        <div class="card-header d-flex justify-content-center">
            <h1>{{ trans('both.update_profile') }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('user.update.profile') }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-3">
                        <div id="profile-container" class="d-flex justify-content-center">
                            <img id="profileImage" src="{{ asset(config('image.folder') . $user->avatar) }}" />
                        </div>
                        <input id="imageUpload" type="file"
                            name="avatar" value="{{ $user->avatar }}" placeholder="Photo" required="" capture>
                        <br>
                        <div class="text-info">
                            {{ trans('both.note_avatar') }}
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="col-9 mt-5">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">
                                {{ trans('supervisor.new_trainee.email') }}
                            </label>
                            <div class="col-sm-9 mt-1">
                                {{ $user->email }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">
                                {{ trans('supervisor.new_trainee.fullname') }}
                            </label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control" name="fullname"
                                    placeholder="{{ trans('supervisor.new_trainee.fullname') }}"
                                    value="{{ $user->fullname }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">
                                {{ trans('supervisor.new_trainee.birthday') }}
                            </label>
                            <div class="col-sm-9">
                                <input required type="date" class="form-control" name="birthday"
                                    placeholder="{{ trans('supervisor.new_trainee.birthday') }}"
                                    value="{{ $user->birthday }}" max="{{ $birthdayMax }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">
                                {{ trans('supervisor.new_trainee.gender') }}
                            </label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio"
                                            name="gender" value="male"
                                            @if ($user->gender == config('number.gender.male'))
                                                checked
                                            @endif>
                                        {{ trans('supervisor.new_trainee.male') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gender"
                                            value="female"
                                            @if ($user->gender == config('number.gender.female'))
                                                checked
                                            @endif>
                                        {{ trans('supervisor.new_trainee.female') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3">
                        <div class="d-flex justify-content-center mt-5">
                            <a href="{{ url()->previous() }}" type="submit"
                                class="btn red mt-1 w-sm">
                                {{ trans('both.cancel') }}
                            </a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary mt-1 w-sm">
                                {{ trans('supervisor.new_trainee.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="col-3"></div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/avatar.js') }}"></script>
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
