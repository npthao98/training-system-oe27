<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Role;
use App\Models\SubjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class TraineeController extends Controller
{
    public function showProgress()
    {
        $user = auth()->user();
        $courses = $user->coursesNotInactive;
        $subjects = $user->subjectsNotInactive;

        return view('trainee.progress', compact('courses', 'subjects'));
    }

    public function showCalendar()
    {
        $subjectUser = auth()->user()->subjectUsersActive;

        return view('trainee.calendar', compact('subjectUser'));
    }

    public function index()
    {
        return view('supervisor.manage-user.list-trainees');
    }

    public function create()
    {
        return view('supervisor.manage-user.create-trainees');
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        if (auth()->user()->role_id == config('number.role.supervisor')) {
            return view('supervisor.manage-user.detail-user');
        } else {
            $trainee = User::find($id)->load('role');
            $courses = $trainee->coursesNotInactive;
            $subjects = $trainee->subjectsNotInactive;
            $subject_id = $trainee->subjectActive->first()->id;

            return view('trainee.detail-member',
                compact('courses', 'subjects', 'subject_id', 'trainee'));
        }
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
