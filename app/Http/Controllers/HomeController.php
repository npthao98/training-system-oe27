<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('changeLanguage');
    }

    public function getdate()
    {
        $courseUser = auth()->user()->courseUserActive->load('course');
        $subjectUser = auth()->user()->subjectUsersActive->load('subject');
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
            User::where('id', auth()->user()->id)
                ->update(['password' => bcrypt($request->newPassword)]);

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
        User::where('id', $request->id)
            ->update([
                'fullname' => $request->fullname,
                'avatar' => $request->avatar->getClientOriginalName(),
                'gender' => $request->gender,
                'birthday' => $request->birthday,
            ]);

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
