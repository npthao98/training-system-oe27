@extends('supervisor.layouts.app')
@section('css')
@endsection
@section('content')
    <div class="card padding">
        <div class="card-header">
            <h3>{{ trans('supervisor.new_trainee.new_trainee') }}</h3>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">
                        {{ trans('supervisor.new_trainee.fullname') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputEmail3" name="fullname"
                            placeholder="{{ trans('supervisor.new_trainee.fullname') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">
                        {{ trans('supervisor.new_trainee.email') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="inputEmail3" name="email"
                            placeholder="{{ trans('supervisor.new_trainee.email') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">
                        {{ trans('supervisor.new_trainee.birthday') }}
                    </label>
                    <div class="col-sm-9">
                        <input id="event-start-date" type="date" class="form-control" name="birthday"
                            placeholder="{{ trans('supervisor.new_trainee.birthday') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">
                        {{ trans('supervisor.new_trainee.gender') }}
                    </label>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio"
                                    name="gender" id="gridRadios1" value="male" checked>
                                {{ trans('supervisor.new_trainee.male') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="gender"
                                    id="gridRadios2" value="female">
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
                            value="123456" id="inputEmail3"
                            placeholder="{{ trans('supervisor.new_trainee.password') }}" disabled>
                        {{ trans('supervisor.new_trainee.default') }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-1">{{ trans('supervisor.new_trainee.submit') }}</button>
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
