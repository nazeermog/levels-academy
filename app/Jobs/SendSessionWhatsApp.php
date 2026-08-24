<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Support\WhatsApp;

/**
 * Sends one session notification over WhatsApp. Mirrors SendSessionInvite: a transport failure
 * is logged but never allowed to crash the request or the queue worker. The message body (with
 * the date/time and Google Calendar link) is fully built at dispatch time.
 */
class SendSessionWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $phone,
        private string $message
    ) {
    }

    public function handle(WhatsApp $whatsapp): void
    {
        try {
            $whatsapp->sendText($this->phone, $this->message);
        } catch (\Throwable $e) {
            Log::error('[WhatsApp] job failed', [
                'phone' => $this->phone,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
