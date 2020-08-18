<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Role;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('supervisor')
            ->except('show');
    }

    public function index()
    {
        $data['courses'] = Course::all()->load([
            'subjects',
            'subjects.subjectUsers',
        ]);
        $data['subjects'] = Subject::all();

        return view('supervisor.manage-subject.list-subjects', $data);
    }

    public function create()
    {
        $courses = Course::where('status', config('number.course.active'))
            ->get();

        return view('supervisor.manage-subject.create-subject',
            compact('courses'));
    }

    public function store(SubjectRequest $request)
    {
        $subject = Subject::create([
            'title' => $request->title,
            'image' => $request->image->getClientOriginalName(),
            'description' => $request->content_description,
            'course_id' => $request->course_id,
            'time' => $request->time,
            'created_at' => now()->format(config('view.format_date.datetime')),
            'status' => config('number.subject.active'),
        ]);

        return redirect()->route('subject.show', ['subject' => $subject->id]);
    }

    public function show($id)
    {
        $user = auth()->user();
        $subjectById = Subject::find($id);
        $subject = $subjectById->load([
            'usersActive',
            'course',
        ]);
        $today = now()->format(config('view.format_date.date'));

        foreach ($subject->usersActive as $user) {
            $todayParse = Carbon::parse($today);
            $startTimeParse = Carbon::parse($user->pivot->start_time);
            $user->time = $startTimeParse->diffInDays($todayParse, false);
        }

        if ($user->role_id == config('number.role.supervisor')) {
            $tasks = $subject->tasks->load('user')
                ->where('created_at', 'like', $today . "%");

            return view('supervisor.manage-subject.detail-subject',
                compact('subject', 'tasks'));
        } else {
            $subjectUser = $subjectById->subjectUsers
                ->where('user_id', $user->id)->first();

            if ($subjectUser) {
                $data['subject'] = $subject;
                $data['tasks'] = $user->tasks
                    ->where('subject_id', $id);
                $data['task_new'] = Task::where([
                    ['subject_id', $id],
                    ['user_id', $user->id],
                    ['status', config('number.task.new')],
                ])->first();
                $data['subjectUser'] = $subjectUser;

                return view('trainee.detail-subject', $data);
            } else {
                abort(404);
            }
        }
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $courses = Course::where('status', config('number.course.active'))
            ->get();

        return view('supervisor.manage-subject.edit-subject',
            compact('subject', 'courses'));
    }

    public function update(SubjectRequest $request, $id)
    {
        $subject = Subject::findOrFail($id)->update([
            'title' => $request->title,
            'image' => $request->image->getClientOriginalName(),
            'description' => $request->content_description,
            'course_id' => $request->course_id,
            'time' => $request->time,
        ]);

        return redirect()->route('subject.show', ['subject' => $id]);

    }

    public function destroy($id)
    {
        $course = Subject::findOrFail($id);
        $this->handelDeleteSubjectUsers($id);
        $this->handelDeleteTasks($id);
        $this->handelDeleteSubject($id);
        $this->handelStatus($course);

        return redirect()->route('subject.index')
            ->with('messenger', trans('both.message.delete_subject_success'));
    }

    public function handelDeleteSubject($subject_id)
    {
        Subject::destroy($subject_id);
    }

    public function handelDeleteSubjectUsers($subject_id)
    {
        SubjectUser::where('subject_id', $subject_id)->delete();
    }

    public function handelDeleteTasks($subject_id)
    {
        Task::where('subject_id', $subject_id)->delete();
    }

    public function handelStatus($course)
    {
        $courseUsersActive = CourseUser::where([
            ['course_id', $course->id],
            ['status', config('number.active')],
        ])->with('user')->get();
        $subjects = $course->subjects->modelKeys();

        foreach ($courseUsersActive as $courseUserActive) {
            $user = $courseUserActive->user;
            $subjectUserActive = $user->subjectUsers
                ->where('status', config('number.active'))
                ->whereIn('subject_id', $subjects)
                ->first();

            if (!$subjectUserActive) {
                $subjectUserInactive = $user->subjectUsers
                    ->where('status', config('number.inactive'))
                    ->whereIn('subject_id', $subjects)->first();

                if ($subjectUserInactive) {
                    SubjectUser::where('id', $subjectUserInactive->id)
                        ->update(['status' => config('number.active')]);
                } else {
                    CourseUser::where([
                        ['course_id', $course->id],
                        ['user_id', $user->id]
                    ])->update(['status' => config('number.passed')]);
                }
            }
        }
    }
}
