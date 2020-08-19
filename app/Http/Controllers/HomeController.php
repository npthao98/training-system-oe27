<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

    public function updatePassword()
    {
    }

    public function editProfile()
    {
        if (auth()->user()->role_id == config('number.role.trainee')) {
            return view('auth.trainee.edit-profile');
        } else {
            return view('auth.supervisor.edit-profile');
        }
    }

    public function updateProfile()
    {
    }

    public function showProfile()
    {
        if (auth()->user()->role_id == config('number.role.trainee')) {
            return view('auth.trainee.detail-profile');
        } else {
            return view('auth.supervisor.detail-profile');
        }
    }
}
