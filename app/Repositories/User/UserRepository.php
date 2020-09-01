<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getSubjectUsersByUser($user, $relation = [])
    {
        return $user->subjectUsers->load($relation);
    }

    public function getCourseUserActiveByUser($user, $relation = [])
    {
        return $user->courseUserActive->load($relation);
    }

    public function getSubjectUsersActiveByUser($user, $relation = [])
    {
        return $user->subjectUsersActive->load($relation);
    }

    public function getCoursesNotInactiveByUser($user, $relation = [])
    {
        return $user->coursesNotInactive->load($relation);
    }

    public function getSubjectsNotInactiveByUser($user, $relation = [])
    {
        return $user->subjectsNotInactive->load($relation);
    }

    public function getCourseInActiveByUser($user, $relation = [])
    {
        return $user->courseInActive->load($relation);
    }

    public function getCourseActiveByUser($user, $relation = [])
    {
        return $user->courseActive->load($relation);
    }

    public function getSubjectActiveByUser($user, $relation = [])
    {
        return $user->subjectActive->load($relation);
    }

    public function getCourseUsersByUser($user, $relation = [])
    {
        return $user->courseUsers->load($relation);
    }
}
