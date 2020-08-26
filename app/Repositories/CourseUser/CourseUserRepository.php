<?php

namespace App\Repositories\CourseUser;

use App\Models\CourseUser;
use App\Repositories\BaseRepository;
use App\Repositories\CourseUser\CourseUserRepositoryInterface;

class CourseUserRepository extends BaseRepository implements CourseUserRepositoryInterface
{
    public function getModel()
    {
        return CourseUser::class;
    }

    public function getUserByCourseUser($courseUser)
    {
        return $courseUser->user;
    }
}
