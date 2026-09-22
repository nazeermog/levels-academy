<?php

namespace Tests\Unit;

use App\Support\SessionMessage;
use Carbon\Carbon;
use Tests\TestCase;

class SessionMessageTest extends TestCase
{
    public function test_it_formats_an_english_reminder_from_a_single_configured_lead_time(): void
    {
        config()->set('services.whatsapp.reminder_lead_hours', 1);

        $message = SessionMessage::reminderBody([
            'classroom_name' => 'Arabic',
            'start_utc' => Carbon::parse('2026-08-12 04:29:00', 'UTC'),
        ], 'Asia/Damascus');

        $this->assertStringContainsString('Reminder from Yasmine Center', $message);
        $this->assertStringContainsString('Your lesson starts in 1 hour.', $message);
        $this->assertStringContainsString('Classroom: Arabic', $message);
        $this->assertStringContainsString('2026-08-12 07:29 (Asia/Damascus)', $message);
    }
}
