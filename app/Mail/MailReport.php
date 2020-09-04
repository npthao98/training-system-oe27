<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Markdown;

class MailReport extends Mailable
{
    use Queueable, SerializesModels;

    protected $trainees;
    protected $times;

    public function __construct($trainees, $times)
    {
        $this->trainees = $trainees;
        $this->times = $times;
    }

    public function build()
    {
        return $this->markdown('mail.report')
            ->with([
                'trainees' => $this->trainees,
                'times' => $this->times,
            ]);
    }
}
