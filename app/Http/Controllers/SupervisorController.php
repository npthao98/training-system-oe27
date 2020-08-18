<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', config('number.role.supervisor'))
            ->get();

        return view('supervisor.manage-user.list-supervisors', compact('users'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $user = User::find($id)->load('role');

        return view('supervisor.manage-user.detail-user', compact('user'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
