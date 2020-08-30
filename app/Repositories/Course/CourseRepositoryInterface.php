<?php

namespace App\Repositories\Course;

interface CourseRepositoryInterface
{
    public function getSubjectsByCourse($course);

    public function getCourseUsersByCourse($course);

    public function getSubjectTasksByCourse($course);
}
