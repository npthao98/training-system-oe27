<?php

namespace App\Repositories\Subject;

interface SubjectRepositoryInterface
{
    public function getTasksBySubject($subject);

    public function getSubjectUsersBySubject($subject);

    public function getCourseBySubject($subject);
}
