<?php

namespace App\Console\Commands;

use App\Jobs\SendDailyInstructorSessionsWhatsApp;
use Illuminate\Console\Command;

class SendDailyInstructorSessions extends Command
{
    protected $signature = 'whatsapp:send-instructor-daily-sessions';

    protected $description = "Queue today's session summary for each instructor";

    public function handle(): int
    {
        SendDailyInstructorSessionsWhatsApp::dispatch()->onQueue('default');

        $this->info("Today's instructor session summary was queued.");
        $this->line('Run the queue worker to send it: php artisan queue:work --queue=default --tries=1 --stop-when-empty');

        return self::SUCCESS;
    }
}
