<?php

namespace App\Jobs;

use Carbon\Carbon;
use DataSource\Entities\Classroom\ClassSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Support\WhatsApp;

class SendDailyInstructorSessionsWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public function handle(WhatsApp $whatsapp): void
    {
        if (!config('services.whatsapp.enabled')) {
            Log::info('[WhatsApp] daily instructor summaries disabled');
            return;
        }

        $timezone = config('app.timezone', 'UTC');
        $today = Carbon::today($timezone);
        $sessions = ClassSession::with(['classroom', 'sessionType', 'instructor'])
            ->whereNotNull('instructor_id')
            ->whereBetween('held_at', [$today->copy()->startOfDay(), $today->copy()->endOfDay()])
            ->orderBy('held_at')
            ->get()
            ->groupBy('instructor_id');

        foreach ($sessions as $instructorSessions) {
            $instructor = $instructorSessions->first()->instructor;
            if (!$instructor) {
                continue;
            }

            $phone = (string) config('services.whatsapp.test_to');
            if ($phone === '') {
                $phone = (string) ($instructor->phone_number ?? '');
            }

            if ($phone === '') {
                Log::warning('[WhatsApp] instructor has no phone number for daily summary', [
                    'instructor_id' => $instructor->id,
                ]);
                continue;
            }

            $message = $this->message($instructor, $instructorSessions, $today);
            if (!$whatsapp->sendText($phone, $message)) {
                Log::error('[WhatsApp] daily instructor summary could not be sent', [
                    'instructor_id' => $instructor->id,
                ]);
            }
        }
    }

    private function message($instructor, $sessions, Carbon $today): string
    {
        $timezone = method_exists($instructor, 'tz') ? $instructor->tz() : config('app.timezone', 'UTC');
        $name = trim($instructor->first_name . ' ' . $instructor->last_name) ?: 'Instructor';
        $lines = [
            'Good morning ' . $name . ',',
            '',
            'Here are your sessions for today (' . $today->format('Y-m-d') . '):',
        ];

        foreach ($sessions->values() as $index => $session) {
            $start = Carbon::parse($session->held_at)->setTimezone($timezone);
            $end = Carbon::parse($session->end_at ?: $session->held_at->copy()->addHour())->setTimezone($timezone);
            $classroom = optional($session->classroom)->name ?: 'Class session';
            $type = optional($session->sessionType)->name;

            $lines[] = '';
            $lines[] = ($index + 1) . '. ' . $start->format('H:i') . ' - ' . $end->format('H:i') . ' (' . $timezone . ')';
            $lines[] = 'Classroom: ' . $classroom;
            if ($type) {
                $lines[] = 'Type: ' . $type;
            }
        }

        return implode("\n", $lines);
    }
}
