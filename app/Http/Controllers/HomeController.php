<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth')->except('changeLanguage');

        $this->userRepo = $userRepo;
    }

    public function getdate()
    {
        $courseUser = $this->userRepo
            ->getCourseUserActiveByUser(auth()->user(), [
                'course',
            ]);
        $subjectUser = $this->userRepo->getSubjectUsersActiveByUser(auth()->user(),
            [
                'subject',
            ]);
        $data = [
            $courseUser,
            $subjectUser,
        ];

        return $data;
    }

    public function index()
    {
        if (auth()->user()->role_id == config('number.role.trainee')) {
            return view('trainee.dashboard');
        } else {
            return view('supervisor.dashboard');
        }
    }

    public function changeLanguage($language)
    {
        Session::put('website_language', $language);
        return redirect()->back();
    }

    public function editPassword()
    {
        if (auth()->user()->role_id == config('number.role.trainee')) {
            return view('auth.trainee.edit-password');
        } else {
            return view('auth.supervisor.edit-password');
        }
    }

    public function updatePassword(Request $request)
    {
        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->back()
                ->with('messenger', trans('both.message.error_password'));
        } else if (strlen($request->newPassword) < config('number.length_password')) {
            return redirect()->back()
                ->with('messenger', trans('both.message.error_new_password'));
        } else if ($request->newPassword != $request->rePassword) {
            return redirect()->back()
                ->with('messenger', trans('both.message.error_re_password'));
        } else {
            $this->userRepo->update(
                auth()->user()->id,
                ['password' => bcrypt($request->newPassword)]
            );

            return redirect()->route('user.detail.profile')
                ->with('messenger', trans('both.message.update_password_success'));
        }
    }

    public function editProfile()
    {
        $birthdayMax = now()->format('Y-m-d');
        $user = auth()->user();

        if ($user->role_id == config('number.role.trainee')) {
            return view('auth.trainee.edit-profile',
                compact('birthdayMax', 'user'));
        } else {
            return view('auth.supervisor.edit-profile',
                compact('birthdayMax', 'user'));
        }
    }

    public function updateProfile(Request $request)
    {
        if (isset($request->avatarReplace)) {
            $avatar = $request->avatarReplace->getClientOriginalName();
        } else {
            $avatar = $request->avatar;
        }
        $this->userRepo->update(
            $request->id,
            [
                'fullname' => $request->fullname,
                'avatar' => $avatar,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
            ]
        );

        return redirect()->route('user.detail.profile')
            ->with('messenger', trans('both.message.update_profile_success'));
    }

    public function showProfile()
    {
        $user = auth()->user();

        if ($user->role_id == config('number.role.trainee')) {
            return view('auth.trainee.detail-profile', compact('user'));
        } else {
            return view('auth.supervisor.detail-profile', compact('user'));
        }
    }
}
