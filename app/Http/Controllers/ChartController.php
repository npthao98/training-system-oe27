<?php

namespace App\Http\Controllers;

use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    protected $courseRepo;

    public function __construct(CourseRepositoryInterface $courseRepo)
    {
        $this->courseRepo = $courseRepo;
    }

    public function getTraineeByCourse()
    {
        $data = $this->courseRepo->getAll(['traineesActive']);

        return $data;
    }
}
