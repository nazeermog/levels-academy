<?php

namespace App\Jobs;

use App\Support\SessionMessage;
use App\Support\WhatsApp;
use Carbon\Carbon;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Student\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class SendSessionReminderWhatsApp implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;
    public array $backoff = [60, 300, 900];
    public int $uniqueFor = 86400;

    public function __construct(public int $sessionId) {}

    public function uniqueId(): string
    {
        return 'session-reminder:' . $this->sessionId;
    }

    public function handle(WhatsApp $whatsapp): void
    {
        if (!config('services.whatsapp.enabled')) {
            Log::info('[WhatsApp] reminders disabled — skipping session reminder', [
                'session_id' => $this->sessionId,
            ]);
            return;
        }

        $session = ClassSession::with(['classroom.students', 'attendee'])->find($this->sessionId);

        if (!$session || $session->reminder_sent_at || !$session->held_at) {
            return;
        }

        $now = now();
        $reminderAt = $session->held_at->copy()->subMinutes(SessionMessage::reminderLeadMinutes());

        if ($session->held_at->lte($now)) {
            Log::info('[WhatsApp] session reminder skipped because session has started', [
                'session_id' => $this->sessionId,
            ]);
            return;
        }

        if ($now->lt($reminderAt)) {
            $this->release(max(1, $now->diffInSeconds($reminderAt)));
            return;
        }

        $sentCount = 0;
        foreach ($this->recipients($session) as $recipient) {
            $message = SessionMessage::reminderBody($this->messageMeta($session), $recipient['timezone']);
            if (!$whatsapp->sendText($recipient['phone'], $message)) {
                throw new RuntimeException('WhatsApp reminder could not be sent.');
            }
            $sentCount++;
        }

        if ($sentCount === 0) {
            Log::warning('[WhatsApp] session reminder has no valid recipients', [
                'session_id' => $this->sessionId,
            ]);
            return;
        }

        $session->forceFill(['reminder_sent_at' => now()])->save();
    }

    private function recipients(ClassSession $session): array
    {
        if ($session->type === ClassSession::TYPE_FREE) {
            $phone = optional(Parentt::find($session->student_user_id))->phone_number
                ?? optional(Student::find($session->student_user_id))->phone_number;
            $user = $session->attendee;

            return $phone && $user ? [[
                'phone' => $phone,
                'timezone' => $user->timezone,
            ]] : [];
        }

        $recipients = [];
        foreach (optional($session->classroom)->students ?? collect() as $studentUser) {
            $student = Student::find($studentUser->id);
            $parent = $student?->parentts()->first();
            $phone = $parent ? $parent->phone_number : null;
            $parentUser = $parent ? $parent->user : null;

            if ($phone && $parentUser) {
                $recipients[$parentUser->id] = [
                    'phone' => $phone,
                    'timezone' => $parentUser->timezone,
                ];
            }
        }

        $recipients = array_values($recipients);

        // In test mode all real recipients are redirected to one number. Send one
        // reminder rather than one copy per parent to that same test number.
        if (config('services.whatsapp.test_to')) {
            return array_slice($recipients, 0, 1);
        }

        return $recipients;
    }

    private function messageMeta(ClassSession $session): array
    {
        $classroomName = optional($session->classroom)->name ?: 'Class session';
        $instructorName = trim((string) optional($session->instructor)->first_name . ' ' . (string) optional($session->instructor)->last_name);
        $domain = parse_url(config('app.url'), PHP_URL_HOST) ?: 'levels-academy.local';

        return [
            'uid' => 'session-reminder-' . $session->id . '@' . $domain,
            'summary' => 'Class Session at ' . $classroomName,
            'description' => 'Classroom: ' . $classroomName . "\n" . (string) ($session->content ?? ''),
            'start_utc' => Carbon::parse($session->held_at)->utc(),
            'end_utc' => Carbon::parse($session->end_at ?: $session->held_at->copy()->addHour())->utc(),
            'classroom_name' => $classroomName,
            'instructor_name' => $instructorName ?: null,
        ];
    }
}
