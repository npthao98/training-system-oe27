<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Role;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class TraineeController extends Controller
{
    public function passSubject($userID, $subjectId)
    {
        $today = now()->format(config('view.format_date.date'));
        SubjectUser::where([
            'user_id' => $userID,
            'subject_id' => $subjectId,
        ])->update([
            'status' => config('number.passed'),
            'end_time' => $today,
        ]);
        $course = Subject::find($subjectId)->course;
        $user = User::find($userID);
        $this->handelStatus($course, $user, $today);

        return redirect()->back()
            ->with('messenger', trans('both.message.update_success'));
    }

    public function active($courseId, $userId)
    {
        CourseUser::where([
            'course_id' => $courseId,
            'user_id' => $userId,
        ])->update(['status' => config('number.active')]);

        $subject = Subject::where('course_id', $courseId)->first();
        SubjectUser::where([
            'user_id' => $userId,
            'subject_id' => $subject->id,
        ])->update(['status' => config('number.active')]);

        return redirect()->route('trainee.show', ['trainee' => $userId]);
    }

    public function assign() {
        return view('supervisor.manage-user.assign');
    }

    public function showProgress()
    {
        $user = auth()->user();
        $courses = $user->coursesNotInactive->sortBy('pivot.start_time');
        $subjects = $user->subjectsNotInactive->sortBy('pivot.start_time');

        return view('trainee.progress', compact('courses', 'subjects'));
    }

    public function showCalendar()
    {
        $subjectUser = auth()->user()->subjectUsersActive;

        return view('trainee.calendar', compact('subjectUser'));
    }

    public function index()
    {
        $users = User::where('role_id', config('number.role.trainee'))
            ->get();
        $courses = Course::with([
                'subjects.users',
                'users',
        ])->get();

        return view('supervisor.manage-user.list-trainees', compact('users', 'courses'));
    }

    public function create()
    {
        $birthdayMax = now()->format('Y-m-d');

        return view('supervisor.manage-user.create-trainee',
            compact('birthdayMax'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'fullname' => $request['fullname'],
            'birthday' => $request['birthday'],
            'gender' => $request['gender'],
            'email' => $request['email'],
            'avatar' => config('view.avatar_default'),
            'password' => bcrypt(config('view.password_default')),
            'status' => config('number.user.active'),
            'role_id' => config('number.role.trainee'),
            'avatar' => config('view.avatar_default'),
        ]);

        return redirect()->route('trainee.show', ['trainee' => $user->id]);
    }

    public function show($id)
    {
        if (auth()->user()->role_id == config('number.role.supervisor')) {
            $user = User::find($id)->load('role');
            $data['coursesProgress'] = $user->coursesNotInactive->sortBy('pivot.start_time');
            $data['subjectsProgress'] = $user->subjectsNotInactive->sortBy('pivot.start_time');
            $data['coursesInActive'] = $user->courseInActive;
            $data['courseActive'] = $user->courseActive;
            $data['user'] = $user;

            return view('supervisor.manage-user.detail-user', $data);
        } else {
            $trainee = User::find($id)->load('role');
            $courses = $trainee->coursesNotInactive->sortBy('pivot.start_time');
            $subjects = $trainee->subjectsNotInactive->sortBy('pivot.start_time');
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
        User::where('id', $id)->update(['password' => bcrypt(config('view.password_default'))]);

        return redirect()->back()
            ->with('messenger', trans('supervisor.detail_user.reset_success'));
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->status == config('number.user.active')) {
            User::where('id', $id)->update(['status' => config('number.user.inactive')]);

            return redirect()->back()
                ->with('messenger', trans('supervisor.detail_user.lock_success'));
        } else {
            User::where('id', $id)->update(['status' => config('number.user.active')]);

            return redirect()->back()
                ->with('messenger', trans('supervisor.detail_user.unlock_success'));
        }
    }

    public function handelStatus($course, $user, $today)
    {
        $subjects = $course->subjects->modelKeys();
        $subject_user_inactive = $user->subjectUsers
            ->where('status', config('number.inactive'))
            ->whereIn('subject_id', $subjects)->first();

        if ($subject_user_inactive) {
            SubjectUser::where('id', $subject_user_inactive->id)
                ->update([
                    'status' => config('number.active'),
                    'start_time' => $today,
                ]);
        } else {
            CourseUser::where([
                ['course_id', $course->id],
                ['user_id', $user->id]
            ])->update([
                'status' => config('number.passed'),
                'end_time' => $today,
            ]);
        }
    }
}
