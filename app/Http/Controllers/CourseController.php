<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Notifications\TraineeNotification;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\CourseUser\CourseUserRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\SubjectUser\SubjectUserRepositoryInterface;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Pusher\Pusher;

class CourseController extends Controller
{
    protected $courseRepo;
    protected $courseUserRepo;
    protected $subjectUserRepo;
    protected $subjectRepo;
    protected $userRepo;
    protected $taskRepo;

    public function __construct(
        CourseRepositoryInterface $courseRepo,
        CourseUserRepositoryInterface $courseUserRepo,
        SubjectUserRepositoryInterface $subjectUserRepo,
        SubjectRepositoryInterface $subjectRepo,
        UserRepositoryInterface $userRepo,
        TaskRepositoryInterface $taskRepo
    ) {
        $this->courseRepo = $courseRepo;
        $this->courseUserRepo = $courseUserRepo;
        $this->subjectUserRepo = $subjectUserRepo;
        $this->subjectRepo = $subjectRepo;
        $this->userRepo = $userRepo;
        $this->taskRepo = $taskRepo;
    }

    public function assign(Request $request, $id)
    {
        $course = $this->courseRepo->getById($id);
        $users = explode(",", $request->users);
        $subjects = $this->courseRepo->getSubjectsByCourse($course);
        $date = now()->format(config('view.format_date.date'));

        foreach ($users as $user) {
            $user_id = intval($user);
            $user_detail = $this->userRepo->getById($user_id);
            $notification = [
                'title' => config('notification.added_course.title'),
                'route_name' => config('notification.added_course.route_name'),
                'id' => $id,
                'user_id' => $user_id,
                'titleable' => $course->title,
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

            $this->courseUserRepo->create([
                'course_id' => $id,
                'user_id' => $user_id,
                'status' => config('number.inactive'),
                'start_time' => $date,
                'end_time' => $date,
            ]);

            foreach ($subjects as $subject) {
                $this->subjectUserRepo->create([
                    'subject_id' => $subject->id,
                    'user_id' => $user_id,
                    'status' => config('number.inactive'),
                    'start_time' => $date,
                    'end_time' => $this->calculatorEndTime($subject->time),
                ]);
            }
        }
        return redirect()->route('course.show', ['course' => $id])
            ->with('messenger', trans('both.message.update_success'));
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == config('number.role.supervisor')) {
            $courses = $this->courseRepo->getAll([
                'subjects',
                'courseUsers',
            ]);

            return view('supervisor.manage-course.list-courses', compact('courses'));
        } else {
            $courseUsers = $this->userRepo
                ->getCourseUsersByUser($user, [
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
        $course = $this->courseRepo->create([
            'title' => $request->title,
            'image' => $request->image->getClientOriginalName(),
            'description' => $request->content_description,
            'created_at' => now()->format(config('view.format_date.datetime')),
            'status' => config('number.subject.active'),
        ]);

        for ($item = 0; $item < count($request->titleSubject); $item++) {
            $this->subjectRepo->create([
                'title' => $request->titleSubject[$item],
                'image' => '',
                'description' => '',
                'course_id' => $course->id,
                'time' => $request->timeSubject[$item],
                'created_at' => now()->format(config('view.format_date.datetime')),
                'status' => config('number.subject.active'),
            ]);
        }

        return redirect()->route('course.show', ['course' => $course->id]);
    }

    public function show($id)
    {
        $user = auth()->user();
        $courseById = $this->courseRepo->getById($id);
        $today = now()->format(config('view.format_date.date'));

        if ($user->role_id == config('number.role.supervisor')) {
            $course = $this->courseRepo->getById($id, [
                'subjects',
                'courseUsers.user.courseActive',
            ]);
            $users = $this->userRepo->getWhereEqual([
                'role_id' => config('number.role.trainee'),
                'status' => config('number.user.active'),
            ])->diff($course->users);
            $data['course'] = $course;
            $data['users'] = $users;

            return view('supervisor.manage-course.detail-course', $data);
        } else {
            $courseUser = $this->courseRepo->getCourseUsersByCourse($courseById)
                ->where('user_id', $user->id)->first();

            if ($courseUser) {
                $course = $this->courseRepo->getById($id, [
                    'subjects',
                    'traineesActive',
                ]);

                foreach ($course->traineesActive as $user) {
                    $todayParse = Carbon::parse($today);
                    $startTimeParse = Carbon::parse($user->pivot->start_time);
                    $user->time = $todayParse->diffInWeekdays($startTimeParse);
                }

                return view('trainee.detail-course', compact('course', 'courseUser'));
            } else {
                abort(404);
            }
        }
    }

    public function edit($id)
    {
        $course = $this->courseRepo->getById($id, ['subjects']);

        return view('supervisor.manage-course.edit-course', compact('course'));
    }

    public function update(CourseRequest $request, $id)
    {
        $this->courseRepo->update($id, [
            'title' => $request->title,
            'image' => $request->image->getClientOriginalName(),
            'description' => $request->content_description,
        ]);

        $course = $this->courseRepo->getById($id);
        $subjectsInit = $this->courseRepo
            ->getSubjectsByCourse($course)->modelKeys();
        $subjectsNotDeleteId = $request->subject_id ? $request->subject_id : [];

        $subjectsNotDelete = $subjectsNotDeleteId;
        $subjectsDelete = array_diff($subjectsInit, $subjectsNotDeleteId);
        $this->handelDeleteSubjectUsers($subjectsDelete);
        $this->handelDeleteTasks($subjectsDelete);
        $this->handelDeleteSubjects($subjectsDelete);
        $this->handelStatus($id, $subjectsNotDelete);
        $totalSubjects = $request->titleSubject ? count($request->titleSubject) : 0;

        for ($item = 0; $item < $totalSubjects; $item++) {
            if (isset($request->subject_id) && $item < count($subjectsNotDelete)) {
                $this->subjectRepo->update($subjectsNotDelete[$item], [
                    'title' => $request->titleSubject[$item],
                    'time' => $request->timeSubject[$item],
                ]);
            } else {
                $this->subjectRepo->create([
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

        return redirect()->route('course.show', ['course' => $id])
            ->with('messenger', trans('both.message.update_success'));
    }

    public function destroy($id)
    {
        $course = $this->courseRepo->getById($id);
        $subjects = $this->courseRepo->getSubjectsByCourse($course)
            ->modelKeys();
        $this->handelDeleteCourseUsers($id);
        $this->handelDeleteSubjectUsers($subjects);
        $this->handelDeleteTasks($subjects);
        $this->handelDeleteSubjects($subjects);
        $this->courseRepo->delete($id);

        return redirect()->route('course.index')
            ->with('messenger', trans('both.message.delete_course_success'));
    }

    public function handelDeleteCourseUsers($courseId)
    {
        $this->courseUserRepo->deleteWhereEqual([
            'course_id' => $courseId,
        ]);
    }

    public function handelDeleteSubjects($subjectsDeleteId)
    {
        $this->subjectRepo->deleteWhereIn('id', $subjectsDeleteId);
    }

    public function handelDeleteSubjectUsers($subjectsDeleteId)
    {
        $this->subjectUserRepo->deleteWhereIn('subject_id', $subjectsDeleteId);
    }

    public function handelDeleteTasks($subjectsDeleteId)
    {
        $this->taskRepo->deleteWhereIn('subject_id', $subjectsDeleteId);
    }

    public function handelStatus($courseId, $subjectsNotDeleteId)
    {
        $courseUsersActive = $this->courseUserRepo
            ->getWhereEqual([
                'course_id' => $courseId,
                'status' => config('number.active'),
            ], ['user']);
        $today = now()->format(config('view.format_date.date'));

        foreach ($courseUsersActive as $courseUserActive) {
            $user = $this->courseUserRepo->getUserByCourseUser($courseUserActive);
            $subjectUserActive = $this->userRepo->getSubjectUsersActiveByUser($user)
                ->whereIn('subject_id', $subjectsNotDeleteId)
                ->first();

            if (!$subjectUserActive) {
                $subjectUserInactive = $this->userRepo->getSubjectUsersByUser($user)
                    ->where('status', config('number.inactive'))
                    ->whereIn('subject_id', $subjectsNotDeleteId)->first();

                if ($subjectUserInactive) {
                    $this->subjectUserRepo
                        ->update($subjectUserInactive->id, [
                            'status' => config('number.active'),
                            'star_time' => $today,
                            'end_time' => $this->calculatorEndTime($subjectUserInactive->subject->time),
                        ]);
                } else {
                    $this->courseUserRepo
                        ->updateWhereEqual([
                            'course_id' => $courseId,
                            'user_id' => $user->id,
                        ], [
                            'status' => config('number.passed'),
                            'end_time' => $today,
                        ]);
                }
            }
        }
    }

    public function calculatorEndTime($time)
    {
        $startTime = Carbon::parse(now()->format(config('view.format_date.date')));
        $guessEndTime = Carbon::parse(now()->addDays($time)->format(config('view.format_date.date')));

        $rangeWithoutWeekend = $guessEndTime->diffInWeekdays($startTime);
        $rangeWeekend = $time - $rangeWithoutWeekend;
        $rangeActual = $time + $rangeWeekend;

        $endTime = now()->addDays($rangeActual)->format(config('view.format_date.date'));

        return $endTime;
    }
}
