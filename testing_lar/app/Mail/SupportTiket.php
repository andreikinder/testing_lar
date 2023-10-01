<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportTiket extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $question;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $question)
    {
        $this->sender = $email;
        $this->question = $question;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.support.ticket');
    }
}
