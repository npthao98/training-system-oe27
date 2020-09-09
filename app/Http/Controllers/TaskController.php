<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\TaskRequest;
use App\Notifications\TraineeNotification;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Pusher\Pusher;

class TaskController extends Controller
{
    protected $courseRepo;
    protected $taskRepo;
    protected $subjectRepo;
    protected $userRepo;

    public function __construct(
        CourseRepositoryInterface $courseRepo,
        TaskRepositoryInterface $taskRepo,
        SubjectRepositoryInterface $subjectRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->middleware('trainee')->only('store');
        $this->middleware('supervisor')->only([
            'index',
            'show',
        ]);
        $this->courseRepo = $courseRepo;
        $this->taskRepo = $taskRepo;
        $this->subjectRepo = $subjectRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $courses = $this->courseRepo
            ->getWhereEqual([
                'status' => config('number.course.active'),
            ], [
                'subjects.tasks',
                'subjectTasks',
            ]);

        foreach ($courses as $course) {
            $course->listTasks = $this->courseRepo->getSubjectTasksByCourse($course)
                ->sortBy('status');

            foreach ($course->subjects as $subject) {
                $subject->listTasks = $this->subjectRepo->getTasksBySubject($subject)
                    ->sortBy('status');
            }
        }
        $tasks = $this->taskRepo->getAll([
            'subject',
            'user',
        ])->sortBy('status');

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
        $this->taskRepo->create($data->all());

        return redirect(route('subject.show', ['subject' => $request['subject_id']]))
            ->with('messenger', trans('trainee.message.create_task'));
    }

    public function show($id)
    {
        $task = $this->taskRepo->getById($id, [
            'user',
            'subject',
        ]);

        return view('supervisor.manage-task.detail-task', compact('task'));
    }

    public function edit($id)
    {
    }

    public function update(TaskRequest $request, $id)
    {
        $user = auth()->user();

        if ($user->role_id == config('number.role.supervisor')) {
            $status = config('number.task.passed');

            if (isset($request['failed'])) {
                $status = config('number.task.failed');
            }
            $this->taskRepo->update($id, [
                'status' => $status,
                'review' => $request['review'],
            ]);
            $task = $this->taskRepo->getById($id);

            $user_detail = $this->userRepo->getById($task->user_id);
            $notification = [
                'title' => config('notification.review_task.title'),
                'route_name' => config('notification.review_task.route_name'),
                'id' => "$task->subject_id",
                'user_id' => $task->user_id,
                'titleable' => $task->created_at,
            ];
            $user_detail->notify(new TraineeNotification($notification));
            $options = array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
            );
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $pusher->trigger(
                config('notification.notification_channel'),
                config('notification.notification_event'),
                $notification
            );
            event(new NotificationEvent($notification));

            return redirect()->route('task.show', ['task' => $id])
                ->with('messenger', trans('trainee.message.update_task'));
        } else {
            $this->taskRepo->update($id, $request->only([
                'plan',
                'next_plan',
                'comment',
                'actual',
            ]));

            return redirect()->back()
                ->with('messenger', trans('trainee.message.update_task'));
        }
    }

    public function destroy($id)
    {
    }
}
