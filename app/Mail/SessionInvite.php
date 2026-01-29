<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SessionInvite extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private string $subjectLine,
        private string $htmlBody,
        private string $icsContent
    ) {
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->html($this->htmlBody)
            ->attachData($this->icsContent, 'invite.ics', [
                'mime' => 'text/calendar; charset=UTF-8; method=REQUEST',
            ]);
    }
}

