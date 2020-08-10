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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/message.css') }}">
@endsection
@section('content')
    @if (isset($messenger))
        <div id="messenger" class="alert alert-success" role="alert">
            <i data-feather="check"></i>
            <span class="mx-2">{{ $messenger }}</span>
        </div>
    @endif
    <div id="main" class="layout-column flex">
        <div id="content" class="flex ">
            <div>
                <div class="page-hero page-container " id="page-hero">
                    <div class="padding d-flex">
                        <div class="page-title">
                            <h2 class="text-md text-highlight">
                                {{ trans('supervisor.detail_task.detail_task') }} -
                                @if ($task->status == config('number.task.new'))
                                    <strong class="text-warning">
                                        {{ trans('supervisor.detail_task.new') }}
                                    </strong>
                                @elseif ($task->status == config('number.task.passed'))
                                    <strong class="text-success">
                                        {{ trans('supervisor.detail_task.passed') }}
                                    </strong>
                                @else
                                    <strong class="text-danger">
                                        {{ trans('supervisor.detail_task.failed') }}
                                    </strong>
                                @endif
                            </h2>
                        </div>
                    </div>
                    <div class="padding">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.date') }}: </strong>
                            </label>
                            <div class="col-sm-10 pt-2">
                                {{ $task->created_at }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.subject') }}: </strong>
                            </label>
                            <div class="col-sm-10 pt-2">
                                {{ $task->subject->title }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.trainee') }}: </strong>
                            </label>
                            <div class="col-sm-10 pt-2">
                                {{ $task->user->fullname }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.plan') }}: </strong>
                            </label>
                            <div class="col-sm-10 pt-2">
                                {{ $task->plan }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.actual') }}: </strong>
                            </label>
                            <div class="col-sm-10 pt-2">
                                {{ $task->actual }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.next_plan') }}: </strong>
                            </label>
                            <div class="col-sm-10 pt-2">
                                {{ $task->next_plan }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                <strong>{{ trans('supervisor.detail_task.comment') }}: </strong>
                            </label>
                            <div class="col-sm-10 pt-2">
                                {{ $task->comment }}
                            </div>
                        </div>
                        <form action="{{ route('task.update', ['task' => $task->id]) }}" method="Post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="plan" value="{{ $task->plan }}">
                            <input type="hidden" name="actual" value="{{ $task->actual }}">
                            <input type="hidden" name="next_plan" value="{{ $task->next_plan }}">
                            <input type="hidden" name="comment" value="{{ $task->comment }}">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    <strong>
                                        {{ trans('supervisor.detail_task.review') }}:
                                    </strong>
                                </label>
                                @if ($task->status == config('number.task.new'))
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="5"
                                            required name="review">{{ old('review') }}</textarea>
                                        @error ('review')
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @else
                                    <div class="col-sm-10 pt-2">
                                        {{ $task->review }}
                                    </div>
                                @endif
                            </div>
                            <br>
                            <div class="row">
                                @if ($task->status == config('number.task.new'))
                                    <div class="col-3"></div>
                                    <div class="col-2 d-flex justify-content-center">
                                        <a href="{{ url()->previous() }}"
                                            class="btn w-sm mb-1 btn-info" name="failed">
                                            {{ trans('both.back') }}
                                        </a>
                                    </div>
                                    <div class="col-2 d-flex justify-content-center">
                                        <input type="submit" class="btn w-sm mb-1 red" name="failed"
                                            value="{{ trans('supervisor.detail_task.fail') }}">
                                    </div>
                                    <div class="col-2 d-flex justify-content-center">
                                        <input type="submit" class="btn w-sm mb-1 btn-success"
                                            name="passed" value="{{ trans('supervisor.detail_task.pass') }}">
                                    </div>
                                    <div class="col-3"></div>
                                @else
                                    <div class="col-12 d-flex justify-content-center">
                                        <a href="{{ url()->previous() }}" class="btn w-sm mb-1 btn-info" name="failed">
                                            {{ trans('both.back') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bower_components/bower_package/typeahead.js/dist/typeahead.bundle.min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/typeahead.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}">
    </script>
    <script src="{{ asset('bower_components/bower_package/js/plugins/fullscreen.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower_package/js/summernote/dist/summernote-bs4.min.js') }}"></script>
@endsection
