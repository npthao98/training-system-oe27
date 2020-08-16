<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Role;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function assign(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $users = explode(",", $request->users);
        $subjects = $course->subjects;
        $date = now()->format(config('view.format_date.date'));

        foreach ($users as $user) {
            CourseUser::create([
                'course_id' => $id,
                'user_id' => intval($user),
                'status' => config('number.inactive'),
                'start_time' => $date,
                'end_time' => $date,
            ]);

            foreach ($subjects as $subject) {
                SubjectUser::create([
                    'subject_id' => $subject->id,
                    'user_id' => intval($user),
                    'status' => config('number.inactive'),
                    'start_time' => $date,
                    'end_time' => now()->addDays($subject->time)
                        ->format(config('view.format_date.date')),
                ]);
            }
        }
        session(['assign' => trans('both.message.update_success')]);

        return redirect()->route('course.show', ['course' => $id]);
    }

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
                'course.subjects',
            ]);

            return view('trainee.list-courses-subjects', compact('courseUsers'));
        }
    }

    public function create()
    {
        return view('supervisor.manage-course.create-course');
    }

    public function store(CourseRequest $request)
    {
        $course = Course::create([
            'title' => $request->title,
            'image' => $request->image->getClientOriginalName(),
            'description' => $request->content_description,
            'created_at' => now()->format(config('view.format_date.datetime')),
            'status' => config('number.subject.active'),
        ]);

        for ($item = 0; $item < count($request->titleSubject); $item++) {
            Subject::create([
                'title' => $request->titleSubject[$item],
                'image' => '',
                'description' => '',
                'course_id' => $course->id,
                'time' => $request->timeSubject[$item],
                'created_at' => now()->format(config('view.format_date.datetime')),
                'status' => config('number.subject.active'),
            ]);;
        }

        return redirect()->route('course.show', ['course' => $course->id]);
    }

    public function show($id)
    {
        $user = auth()->user();
        $courseById = Course::find($id);

        if ($user->role_id == config('number.role.supervisor')) {
            if (session()->has('assign')) {
                $data['messenger'] = session('assign');
                session()->forget('assign');
            }
            $course = $courseById->load([
                'subjects',
                'courseUsers.user',
            ]);
            $users = User::where([
                ['role_id', config('number.role.trainee')],
                ['status', config('number.user.active')]
            ])->get()->diff($course->users);
            $data['course'] = $course;
            $data['users'] = $users;

            return view('supervisor.manage-course.detail-course', $data);
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
