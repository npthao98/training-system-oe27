<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Role;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\Task;
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
        $courses = Course::all()->load([
            'subjects',
            'subjects.subjectUsers',
        ]);
        $subjects = Subject::paginate(config('view.paginate_10'));

        return view('supervisor.manage-subject.list-subjects',
            compact('courses', 'subjects'));
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

        if ($user->role_id == config('number.role.supervisor')) {
            $today = now()->format(config('view.format_date.date'));
            $subject = Subject::find($id)->load('usersActive');
            $tasks = $subject->tasks->load('user')
                ->where('created_at', 'like', $today . "%");

            return view('supervisor.manage-subject.detail-subject',
                compact('subject', 'tasks'));
        } else {
            $subjectUser = $subjectById->subjectUsers
                ->where('user_id', $user->id)->first();

            if ($subjectUser) {
                $data['subject'] = $subjectById->load('usersActive');
                $data['tasks'] = $user->tasks
                    ->where('subject_id', $id);
                $data['subjectUser'] = $subjectUser;

                if (session()->has('messageTask')) {
                    $data['messenger'] = session('messageTask');
                    session()->forget('messageTask');
                }

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
    }
}
