<?php

namespace App\Support;

use Carbon\Carbon;
use DateTimeInterface;

/**
 * Formats the plain-text WhatsApp body for a session notification, shared by the class-session
 * and free-trial flows. Times render in the recipient's timezone when we know it (auto-detected
 * at login), otherwise UTC. Ends with a tappable Google Calendar link built from the same event.
 */
class SessionMessage
{
    /**
     * @param array $meta   summary, description?, start_utc, end_utc (DateTimeInterface),
     *                      plus optional classroom_name, instructor_name, location.
     * @param string|null $tz  recipient IANA timezone (falls back to UTC when unknown/invalid).
     */
    public static function whatsappBody(array $meta, ?string $tz = null): string
    {
        /** @var DateTimeInterface $startUtc */
        $startUtc = $meta['start_utc'];
        /** @var DateTimeInterface $endUtc */
        $endUtc = $meta['end_utc'];

        $useTz = ($tz && in_array($tz, timezone_identifiers_list(), true)) ? $tz : null;
        $zone  = $useTz ?: 'UTC';
        $label = $useTz ? ' (' . $useTz . ')' : ' UTC';

        $startText = Carbon::parse($startUtc)->setTimezone($zone)->format('Y-m-d H:i') . $label;
        $endText   = Carbon::parse($endUtc)->setTimezone($zone)->format('H:i') . $label;

        $lines = [];
        $lines[] = '📅 ' . ($meta['summary'] ?? 'Session');
        if (!empty($meta['classroom_name'])) {
            $lines[] = 'Classroom: ' . $meta['classroom_name'];
        }
        if (!empty($meta['instructor_name'])) {
            $lines[] = 'Instructor: ' . $meta['instructor_name'];
        }
        $lines[] = '🕒 ' . $startText . ' → ' . $endText;
        $lines[] = '';
        $lines[] = '➕ Add to your calendar:';
        $lines[] = CalendarLink::google($meta);

        return implode("\n", $lines);
    }

    public static function reminderLeadMinutes(): int
    {
        $hours = (float) config('services.whatsapp.reminder_lead_hours', 2);
        $hours = $hours > 0 ? $hours : 2;

        return (int) round($hours * 60);
    }

    public static function reminderLeadText(): string
    {
        $minutes = self::reminderLeadMinutes();
        $hours = intdiv($minutes, 60);
        $remainder = $minutes % 60;

        if ($hours > 0 && $remainder === 0) {
            return $hours === 1 ? '1 hour' : $hours . ' hours';
        }

        if ($hours > 0) {
            $hourText = $hours === 1 ? '1 hour' : $hours . ' hours';
            $minuteText = $remainder === 1 ? '1 minute' : $remainder . ' minutes';

            return $hourText . ' and ' . $minuteText;
        }

        return $minutes === 1 ? '1 minute' : $minutes . ' minutes';
    }

    public static function reminderBody(array $meta, ?string $tz = null): string
    {
        $useTz = ($tz && in_array($tz, timezone_identifiers_list(), true)) ? $tz : null;
        $zone = $useTz ?: 'UTC';
        $label = $useTz ? ' (' . $useTz . ')' : ' UTC';
        $startText = Carbon::parse($meta['start_utc'])->setTimezone($zone)->format('Y-m-d H:i') . $label;

        return implode("\n", [
            'Reminder from Yasmine Center',
            '',
            'Your lesson starts in ' . self::reminderLeadText() . '.',
            '',
            'Classroom: ' . ($meta['classroom_name'] ?? 'Class session'),
            'Time: ' . $startText,
        ]);
    }
}
