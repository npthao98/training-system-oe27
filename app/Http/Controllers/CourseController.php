<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Role;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\Task;
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
            if (session()->has('course')) {
                $data['messenger'] = session('course');
                session()->forget('course');
            }
            $data['courses'] = Course::withCount([
                'subjects',
                'courseUsers',
            ])->paginate(config('view.paginate_10'));

            return view('supervisor.manage-course.list-courses', $data);
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
            } elseif (session()->has('course')) {
                $data['messenger'] = session('course');
                session()->forget('course');
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
        $course = Course::findOrFail($id)
            ->load('subjects');

        return view('supervisor.manage-course.edit-course', compact('course'));
    }

    public function update(CourseRequest $request, $id)
    {
        Course::findOrFail($id)->update([
            'title' => $request->title,
            'image' => $request->image->getClientOriginalName(),
            'description' => $request->content_description,
        ]);

        $course = Course::find($id);
        if (isset($request->subject_id)) {
            $subjectsInit = $course->subjects->modelKeys();
            $subjectsNotDelete = Subject::whereIn('id', $request->subject_id)
                ->get()->modelKeys();
            $subjectsDelete = array_diff($subjectsInit, $subjectsNotDelete);
            $this->handelDeleteSubjectUsers($subjectsDelete);
            $this->handelDeleteTasks($subjectsDelete);
            $this->handelDeleteSubjects($subjectsDelete);
            $this->handelStatus($id, $subjectsNotDelete);
        }

        for ($item = 0; $item < count($request->titleSubject); $item++) {
            if (isset($request->subject_id) && $item < count($subjectsNotDelete)) {
                Subject::findOrFail($subjectsNotDelete[$item])
                    ->update([
                        'title' => $request->titleSubject[$item],
                        'time' => $request->timeSubject[$item],
                    ]);
            } else {
                Subject::create([
                    'title' => $request->titleSubject[$item],
                    'image' => '',
                    'description' => '',
                    'course_id' => $id,
                    'time' => $request->timeSubject[$item],
                    'created_at' => now()->format(config('view.format_date.datetime')),
                    'status' => config('number.subject.active'),
                ]);
            }
        }
        session(['course' => trans('both.message.update_success')]);

        return redirect()->route('course.show', ['course' => $id]);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $subjects = $course->subjects->modelKeys();
        $this->handelDeleteCourseUsers($id);
        $this->handelDeleteSubjectUsers($subjects);
        $this->handelDeleteTasks($subjects);
        $this->handelDeleteSubjects($subjects);
        Course::destroy($id);
        session(['course' => trans('both.message.delete_course_success')]);

        return redirect()->route('course.index');
    }

    public function handelDeleteCourseUsers($courseId)
    {
        CourseUser::where('course_id', $courseId)->delete();
    }

    public function handelDeleteSubjects($subjectsDeleteId)
    {
        Subject::destroy($subjectsDeleteId);
    }

    public function handelDeleteSubjectUsers($subjectsDeleteId)
    {
        SubjectUser::whereIn('subject_id', $subjectsDeleteId)->delete();
    }

    public function handelDeleteTasks($subjectsDeleteId)
    {
        Task::whereIn('subject_id', $subjectsDeleteId)->delete();
    }

    public function handelStatus($courseId, $subjectsNotDeleteId)
    {
        $courseUsersActive = CourseUser::where([
            ['course_id', $courseId],
            ['status', config('number.active')],
        ])->with('user')->get();

        foreach ($courseUsersActive as $courseUserActive) {
            $user = $courseUserActive->user;
            $subjectUserActive = $user->subjectUsers
                ->where('status', config('number.active'))
                ->whereIn('subject_id', $subjectsNotDeleteId)
                ->first();

            if ($subjectUserActive) {
                $subjectUserInactive = $user->subjectUsers
                    ->where('status', config('number.inactive'))
                    ->whereIn('subject_id', $subjectsNotDeleteId)->first();

                if (!$subjectUserInactive) {
                    SubjectUser::where('id', $subjectUserInactive->id)
                        ->update(['status' => config('number.active')]);
                } else {
                    CourseUser::where([
                        ['course_id', $courseId],
                        ['user_id', $user->id]
                    ])->update(['status' => config('number.passed')]);
                }
            }
        }
    }
}
