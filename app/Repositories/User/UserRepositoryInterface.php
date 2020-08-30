<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function getSubjectUsersByUser($user, $relation = []);

    public function getCourseUserActiveByUser($user, $relation = []);

    public function getSubjectUsersActiveByUser($user, $relation = []);

    public function getCoursesNotInactiveByUser($user, $relation = []);

    public function getSubjectsNotInactiveByUser($user, $relation = []);

    public function getCourseInActiveByUser($user, $relation = []);

    public function getCourseActiveByUSer($user, $relation = []);

    public function getSubjectActiveByUSer($user, $relation = []);

    public function getCourseUsersByUser($user, $relation = []);
}
