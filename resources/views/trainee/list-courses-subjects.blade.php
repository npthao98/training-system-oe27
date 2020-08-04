@extends('trainee.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bower_package/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/supervisor_list_courses.css') }}">
@endsection
@section('content')
    <div id="accordion" class="mb-4 padding">
        <div class="card mb-1">
            <div class="card-header no-border" id="headingOne">
                <a href="#" data-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="false" aria-controls="collapseOne">
                    {{--Course #1--}}
                    <span>
                        <a href="#" class="float-right">
                            <i data-feather="chevrons-right"></i>
                        </a>
                    </span>
                </a>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action">
                            <a href="#">
                                {{--Subject--}}
                            </a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="#">
                                {{--Subject--}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card mb-1">
            <div class="card-header no-border" id="headingTwo">
                <a href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo">
                    {{--Course #2--}}
                </a>
                <span>
                    <a href="#" class="float-right">
                        <i data-feather="chevrons-right"></i>
                    </a>
                </span>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action">
                            <a href="#">
                                {{--Subject--}}
                            </a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="#">
                                {{--Subject--}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card mb-1">
            <div class="card-header no-border" id="headingThree">
                <a href="#" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="false" aria-controls="collapseThree">
                    {{--Course #3--}}
                    <span>
                        <a href="#" class="float-right">
                            <i data-feather="chevrons-right"></i>
                        </a>
                    </span>
                </a>
            </div>
            <div id="collapseThree" class="collapse"
                aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action">
                            <a href="#">
                                {{--Subject--}}
                            </a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="#">
                                {{--Subject--}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('bower_components/bower_package/jquery/dist/jquery.min.js') }}"></script>
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
