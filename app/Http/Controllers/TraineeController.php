<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\CourseUser\CourseUserRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\SubjectUser\SubjectUserRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TraineeController extends Controller
{
    protected $subjectUserRepo;
    protected $subjectRepo;
    protected $userRepo;
    protected $courseRepo;
    protected $courseUserRepo;

    public function __construct(
        SubjectUserRepositoryInterface $subjectUserRepo,
        SubjectRepositoryInterface $subjectRepo,
        UserRepositoryInterface $userRepo,
        CourseRepositoryInterface $courseRepo,
        CourseUserRepositoryInterface $courseUserRepo
    ) {
        $this->subjectUserRepo = $subjectUserRepo;
        $this->subjectRepo = $subjectRepo;
        $this->userRepo = $userRepo;
        $this->courseRepo = $courseRepo;
        $this->courseUserRepo = $courseUserRepo;
    }

    public function passSubject($userID, $subjectId)
    {
        $today = now()->format(config('view.format_date.date'));
        $this->subjectUserRepo->updateWhereEqual([
            'user_id' => $userID,
            'subject_id' => $subjectId,
        ], [
            'status' => config('number.passed'),
            'end_time' => $today,
        ]);
        $subject = $this->subjectRepo->getById($subjectId);
        $course = $this->subjectRepo->getCourseBySubject($subject);
        $user = $this->userRepo->getById($userID);
        $this->handelStatus($course, $user);

        return redirect()->back()
            ->with('messenger', trans('both.message.update_success'));
    }

    public function activeCourse($userId, $courseId)
    {
        $today = now()->format(config('view.format_date.date'));
        $course = $this->courseRepo->getById($courseId);
        $subjects = $this->courseRepo->getSubjectsByCourse($course);
        $time = config('number.total_init');

        foreach ($subjects as $subject_detail) {
            $time += $subject_detail->time;
        }
        $this->courseUserRepo->updateWhereEqual([
            'course_id' => $courseId,
            'user_id' => $userId,
        ], [
            'status' => config('number.active'),
            'start_time' => $today,
            'end_time' => $this->calculatorEndTime($time),
        ]);
        $subject = $this->subjectRepo->getWhereEqual([
            'course_id' => $courseId,
        ])->first();
        $this->subjectUserRepo->updateWhereEqual([
            'user_id' => $userId,
            'subject_id' => $subject->id,
        ], [
            'status' => config('number.active'),
            'start_time' => $today,
            'end_time' => $this->calculatorEndTime($subject->time),
        ]);

        return redirect()->back()
            ->with('messenger', trans('both.message.update_success'));
    }

    public function assign() {
        return view('supervisor.manage-user.assign');
    }

    public function showProgress()
    {
        $user = auth()->user();
        $courses = $this->userRepo->getCoursesNotInactiveByUser($user)
            ->sortBy('pivot.start_time');
        $subjects = $this->userRepo->getSubjectsNotInactiveByUser($user)
            ->sortBy('pivot.start_time');

        return view('trainee.progress', compact('courses', 'subjects'));
    }

    public function index()
    {
        $users = $this->userRepo->getWhereEqual([
            'role_id' => config('number.role.trainee'),
        ]);
        $courses = $this->courseRepo->getAll([
            'subjects.users',
            'users',
        ]);

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
        $user = $this->userRepo->create([
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
            $user = $this->userRepo->getById($id, [
                'role',
            ]);
            $data['coursesProgress'] = $this->userRepo->getCoursesNotInactiveByUser($user)
                ->sortBy('pivot.start_time');
            $data['subjectsProgress'] = $this->userRepo->getSubjectsNotInactiveByUser($user)
                ->sortBy('pivot.start_time');
            $data['coursesInActive'] = $this->userRepo->getCourseInActiveByUser($user);
            $data['courseActive'] = $this->userRepo->getCourseActiveByUSer($user);
            $data['user'] = $user;

            return view('supervisor.manage-user.detail-user', $data);
        } else {
            $trainee = $this->userRepo->getById($id, [
                'role',
            ]);
            $courses = $this->userRepo->getCoursesNotInactiveByUser($trainee)
                ->sortBy('pivot.start_time');
            $subjects = $this->userRepo->getSubjectsNotInactiveByUser($trainee)
                ->sortBy('pivot.start_time');
            $subject_id = $this->userRepo->getSubjectActiveByUser($trainee)
                ->first()->id;

            return view('trainee.detail-member',
                compact('courses', 'subjects', 'subject_id', 'trainee'));
        }
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $this->userRepo->update($id, [
            'password' => bcrypt(config('view.password_default')),
        ]);

        return redirect()->back()
            ->with('messenger', trans('supervisor.detail_user.reset_success'));
    }

    public function destroy($id)
    {
        $user = $this->userRepo->getById($id);

        if ($user->status == config('number.user.active')) {
            $this->userRepo->update($id, [
                'status' => config('number.user.inactive'),
            ]);

            return redirect()->back()
                ->with('messenger', trans('supervisor.detail_user.lock_success'));
        } else {
            $this->userRepo->update($id, [
                'status' => config('number.user.active'),
            ]);

            return redirect()->back()
                ->with('messenger', trans('supervisor.detail_user.unlock_success'));
        }
    }

    public function handelStatus($course, $user)
    {
        $subjects = $this->courseRepo->getSubjectsByCourse($course)
            ->modelKeys();
        $subjectUserInactive = $this->userRepo->getSubjectUsersByUser($user)
            ->where('status', config('number.inactive'))
            ->whereIn('subject_id', $subjects)->first();
        $startTime = now()->format(config('view.format_date.date'));

        if ($subjectUserInactive) {
            $this->subjectUserRepo
                ->update($subjectUserInactive->id, [
                    'status' => config('number.active'),
                    'start_time' => $startTime,
                    'end_time' => $this->calculatorEndTime($subjectUserInactive->subject->time),
                ]);
        } else {
            $this->courseUserRepo->updateWhereEqual([
                'course_id' => $course->id,
                'user_id' => $user->id,
            ], [
                'status' => config('number.passed'),
                'end_time' => $startTime,
            ]);
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
