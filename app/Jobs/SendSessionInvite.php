<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SessionInvite;

class SendSessionInvite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $toEmail,
        private string $subjectLine,
        private string $htmlBody,
        private string $icsContent
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->toEmail)->send(
            new SessionInvite($this->subjectLine, $this->htmlBody, $this->icsContent)
        );
    }
}

