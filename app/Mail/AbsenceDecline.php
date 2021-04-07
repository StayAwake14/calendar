<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbsenceDecline extends Mailable
{
    use Queueable, SerializesModels;

    public $absence, $user, $leader;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($absence, $user, $leader)
    {
        $this->subject('MCCORP - Absence Decline');
        $this->absence = $absence;
        $this->user = $user;
        $this->leader = $leader;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.absence_decline');
    }
}
