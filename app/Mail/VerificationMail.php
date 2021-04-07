<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $absence, $leader;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($absence, $leader)
    {
        $this->subject('MCCORP - Absence Verification');
        $this->absence = $absence;
        $this->leader = $leader;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.verification_mail');
    }
}
