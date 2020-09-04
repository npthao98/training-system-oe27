<?php

namespace App\Console;

use App\Console\Commands\SendMail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SendMail::class,
    ];

    protected function schedule(Schedule $schedule)
    {
         $schedule->command('email:report')
             ->weeklyOn(config('number.report_weekday'), config('number.report_hour'));
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
