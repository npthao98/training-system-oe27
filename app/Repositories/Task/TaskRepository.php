<?php

namespace App\Repositories\Task;

use App\Models\Course;
use App\Models\Task;
use App\Repositories\BaseRepository;
use App\Repositories\Course\CourseRepositoryInterface;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function getModel()
    {
        return Task::class;
    }
}
