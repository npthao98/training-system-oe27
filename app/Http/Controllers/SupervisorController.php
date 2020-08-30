<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $users = $this->userRepo
            ->getWhereEqual(['role_id' => config('number.role.supervisor')]);

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
        $user = $this->userRepo->getById($id, ['role']);

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
