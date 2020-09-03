@component('mail::message')
    # Progress of Trainees
@component('mail::table')
|{{ trans('supervisor.mail.report.id') }}|{{ trans('supervisor.mail.report.name') }}|{{ trans('supervisor.mail.report.email') }}|{{ trans('supervisor.mail.report.course_active') }}|{{ trans('supervisor.mail.report.subject_active') }}|{{ trans('supervisor.mail.report.days') }}|
| :-----: |:-------- | :-------- | :-------- | :-------- | :----: |
@foreach ($trainees as $index => $trainee)
@php
    $courseActive = $trainee->courseUserActive->first();
    $subjectActive = $trainee->subjectUsersActive->first();
    $courseTitle = isset($courseActive) ? $courseActive->course->title : "N/A";
    $subjectTitle = isset($subjectActive) ? $subjectActive->subject->title : "N/A";
@endphp
|{{ $index + config('number.init') }}|{{ $trainee->fullname }}|{{ $trainee->email }}|{{ $courseTitle }}|{{ $subjectTitle }}|{{ $times[$trainee->id] }}|
@endforeach
@endcomponent
@endcomponent
