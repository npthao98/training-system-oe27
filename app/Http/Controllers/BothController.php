<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BothController extends Controller
{
    /*
     * Change language
     * */
    public function changeLanguage($language)
    {
        Session::put('website_language', $language);

        return redirect()->back();
    }

    public function index()
    {
        return view('trainee.progress');
    }
}
