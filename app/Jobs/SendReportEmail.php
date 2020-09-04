<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailReport;

class SendReportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $supervisors;
    protected $trainees;
    protected $times;

    public function __construct($supervisors, $trainees, $times)
    {
        $this->supervisors = $supervisors;
        $this->trainees = $trainees;
        $this->times = $times;
    }

    public function handle()
    {
        foreach ($this->supervisors as $supervisor) {
            Mail::to($supervisor)->send(new MailReport($this->trainees, $this->times));
        }
    }
}
