<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;
    public $clientName;

    /**
     * Create a new message instance.
     */
    public function __construct($reply, $clientName)
    {
        $this->reply = $reply;
        $this->clientName = $clientName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Response to Your Complaint')
                    ->view('emails.complaint_reply');
    }
}
