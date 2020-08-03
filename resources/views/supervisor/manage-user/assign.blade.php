@extends('supervisor.layouts.app')
@section('css')
@endsection
@section('content')
    <div class="card padding">
        <div class="d-flex justify-content-center">
            <h2>{{ trans('supervisor.assign.assign') }}</h2>
        </div>
        <div class="b-b">
            <div class="nav-active-border b-success top">
                <ul class="nav" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab"
                            href="#" role="tab" aria-controls="home" aria-selected="true">
                            {{ trans('supervisor.assign.course') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab"
                            href="#" role="tab" aria-controls="profile" aria-selected="false">
                            {{ trans('supervisor.assign.subject') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content p-3">
            <div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab">
                <form action="#" method="POST" class="padding">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            {{ trans('supervisor.assign.course') }}
                        </label>
                        <div class="col-sm-10">
                            <input list="brow" class="form-control">
                            <datalist id="brow">
                                <option value="value">
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            {{ trans('supervisor.assign.trainee') }}
                        </label>
                        <div class="col-sm-10">
                            <input list="brow" class="form-control">
                            <datalist id="brow">
                                <option value="value">
                            </datalist>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-1">
                            {{ trans('supervisor.new_trainee.submit') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab">
                <form action="#" method="POST" class="padding">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            {{ trans('supervisor.assign.subject') }}
                        </label>
                        <div class="col-sm-10">
                            <input list="brow" class="form-control">
                            <datalist id="brow">
                                <option value="value">
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            {{ trans('supervisor.assign.trainee') }}
                        </label>
                        <div class="col-sm-10">
                            <input list="brow" class="form-control">
                            <datalist id="brow">
                                <option value="value">
                            </datalist>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-1">
                            {{ trans('supervisor.new_trainee.submit') }}
                        </button>
                    </div>
                </form>
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
