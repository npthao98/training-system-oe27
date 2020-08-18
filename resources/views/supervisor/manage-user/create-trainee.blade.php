@extends('supervisor.layouts.app')
@section('css')
@endsection
@section('content')
    <div class="card padding">
        <div class="card-header">
            <h3>{{ trans('supervisor.new_trainee.new_trainee') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('trainee.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">
                        {{ trans('supervisor.new_trainee.fullname') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="text" required class="form-control" name="fullname"
                            placeholder="{{ trans('supervisor.new_trainee.fullname') }}"
                            value="{{ old('fullname') }}">
                        @error ('titleSubject[]')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">
                        {{ trans('supervisor.new_trainee.email') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="email" required class="form-control" name="email"
                            placeholder="{{ trans('supervisor.new_trainee.email') }}"
                            value="{{ old('email') }}">
                        @error ('titleSubject[]')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">
                        {{ trans('supervisor.new_trainee.birthday') }}
                    </label>
                    <div class="col-sm-9">
                        <input required type="date" class="form-control" name="birthday"
                            placeholder="{{ trans('supervisor.new_trainee.birthday') }}"
                            value="{{ old('birthday') }}" max="{{ $birthdayMax }}">
                        @error ('titleSubject[]')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
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
                                    name="gender" value="male" checked>
                                {{ trans('supervisor.new_trainee.male') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="gender"
                                    value="female">
                                {{ trans('supervisor.new_trainee.female') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">
                        {{ trans('supervisor.new_trainee.password') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control"
                            value="password" id="inputEmail3"
                            placeholder="{{ trans('supervisor.new_trainee.password') }}" disabled>
                        {{ trans('supervisor.new_trainee.default') }}
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary mt-1 w-sm">
                        {{ trans('supervisor.new_trainee.submit') }}
                    </button>
                </div>
            </form>
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
