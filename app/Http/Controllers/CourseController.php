<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Role;
use App\Models\Subject;
use App\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == config('number.role.supervisor')) {
            $courses = Course::withCount([
                'subjects',
                'courseUsers',
            ])->paginate(config('view.paginate_10'));

            return view('supervisor.manage-course.list-courses', compact('courses'));
        } else {
            $courseUsers = $user->courseUsers->load([
                'course',
                'course.subject',
            ]);

            return view('trainee.list-courses-subjects', compact('courseUsers'));
        }
    }

    public function create()
    {
        return view('supervisor.manage-course.create-course');
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $user = auth()->user();
        $courseById = Course::find($id);

        if ($user->role_id == config('number.role.supervisor')) {
            $course = $courseById->load([
                'subjects',
                'users',
            ]);

            return view('supervisor.manage-course.detail-course', compact('course'));
        } else {
            $courseUser = $courseById->courseUsers
                ->where('user_id', $user->id)->first();

            if ($courseUser) {
                $course = $courseById->load([
                    'subjects',
                    'traineesActive',
                ]);

                return view('trainee.detail-course', compact('course', 'courseUser'));
            } else {
                abort(404);
            }
        }
    }

    public function edit($id)
    {
        return view('supervisor.manage-course.edit-course');
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
