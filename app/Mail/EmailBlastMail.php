<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBlastMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $emailSubject,
        public string $bodyHtml,
        public string $guestName = 'Valued Guest'
    ) {}

    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->view('emails.blast');
    }
}
