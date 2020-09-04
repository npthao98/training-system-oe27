<?php

namespace App\Console\Commands;

use App\Jobs\SendReportEmail;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMail extends Command
{
    protected $userRepo;
    protected $signature = 'email:report';

    public function __construct(UserRepositoryInterface $userRepo)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
    }

    public function handle()
    {
        $supervisors = $this->userRepo
            ->getWhereEqual([
                'role_id' => config('number.role.supervisor'),
                'status' => config('number.user.active'),
            ]);
        $trainees = $this->userRepo
            ->getWhereEqual([
                'role_id' => config('number.role.trainee'),
                'status' => config('number.user.active'),
            ], [
                'courseUserActive.course',
                'subjectUsersActive.subject',
            ]);
        $today = now()->format(config('view.format_date.date'));
        $todayParse = Carbon::parse($today);
        $times = [];

        foreach ($trainees as $trainee) {
            if ($trainee->courseUserActive->isNotEmpty()) {
                $courseActive = $trainee->courseUserActive->first();
                $startTimeParse = Carbon::parse($courseActive->start_time);
                $times[$trainee->id] = $todayParse->diffInWeekdays($startTimeParse);
            } else {
                $times[$trainee->id] = 'N/A';
            }
        }
        if (!empty($supervisors)) {
            SendReportEmail::dispatch($supervisors, $trainees, $times)->onQueue('emails');
        }
    }
}
