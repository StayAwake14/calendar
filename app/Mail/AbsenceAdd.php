<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbsenceAdd extends Mailable
{
    use Queueable, SerializesModels;

    public $absences, $user, $reason;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($absences, $user, $reason)
    {
        $this->subject('MCCORP - Absence Approve');
        $this->absences = $absences;
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.absence_add');
    }
}
