<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
use App\Repositories\BaseRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{
    public function getModel()
    {
        return Subject::class;
    }

    public function getTasksBySubject($subject)
    {
        return $subject->tasks;
    }

    public function getSubjectUsersBySubject($subject)
    {
        return $subject->subjectUsers;
    }

    public function getCourseBySubject($subject)
    {
        return $subject->course;
    }
}
