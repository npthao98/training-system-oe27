<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Course;
use App\Models\Role;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('trainee')->only('store');
        $this->middleware('supervisor')->only('index');
    }

    public function index()
    {
        $courses = Course::where('status', config('number.course.active'))
            ->with([
                'subjects.tasks',
                'subjectTasks',
            ])->get();

        foreach ($courses as $course) {
            $course->subjectTasks = $course->subjectTasks->sortBy('status');

            foreach ($course->subjects as $subject) {
                $subject->tasks = $subject->tasks->sortBy('status');
            }
        }
        $tasks = Task::with([
            'subject',
            'user',
        ])->orderBy('status')->get();

        return view('supervisor.manage-task.list-tasks', compact('courses', 'tasks'));
    }

    public function create()
    {
    }

    public function store(TaskRequest $request)
    {
        $data['user_id']  = auth()->user()->id;
        $data['status'] = config('number.task.new');
        $data['created_at'] = now()->format(config('view.format_date.datetime'));
        $data = $request->merge($data);
        Task::create($data->all());
        session(['messageTask' => trans('trainee.message.create_task')]);

        return redirect(route('subject.show', ['subject' => $request['subject_id']]));
    }

    public function show($id)
    {
        $data['task'] = Task::find($id)->load([
            'user',
            'subject',
        ]);
        if (session()->has('messageTask')) {
            $data['messenger'] = session('messageTask');
            session()->forget('messageTask');
        }

        return view('supervisor.manage-task.detail-task', $data);
    }

    public function edit($id)
    {
    }

    public function update(TaskRequest $request, $id)
    {
        if (auth()->user()->role_id == config('number.role.supervisor')) {
            $status = config('number.task.passed');

            if (isset($request['failed'])) {
                $status = config('number.task.failed');
            }
            Task::where('id', $id)
                ->update([
                    'status' => $status,
                    'review' => $request['review'],
                ]);
            session(['messageTask' => trans('trainee.message.update_task')]);

            return redirect()->route('task.show', ['task' => $id]);
        } else {
            $task = Task::find($id);
            $task->update($request->only(['plan', 'next_plan', 'comment', 'actual']));
            session(['messageTask' => trans('trainee.message.update_task')]);

            return redirect(route('subject.show', ['subject' => $task->subject_id]));
        }
    }

    public function destroy($id)
    {
    }
}
