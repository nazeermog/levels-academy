<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
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
        try {
            Mail::to($this->toEmail)->send(
                new SessionInvite($this->subjectLine, $this->htmlBody, $this->icsContent)
            );
        } catch (\Throwable $e) {
            // Never let a mail/transport failure crash the request or the queue worker.
            Log::error('[SessionInvite] send failed', [
                'to'    => $this->toEmail,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

