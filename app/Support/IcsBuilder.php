<?php

namespace App\Support;

use DateTimeInterface;

class IcsBuilder
{
    private static function escape(string $text): string
    {
        return str_replace(
            ["\\", ",", ";", "\n", "\r"],
            ["\\\\", "\\,", "\\;", "\\n", ""],
            $text
        );
    }

    public static function buildInvite(array $event): string
    {
        // Required: uid, summary, description, organizer_email, start_utc(DateTimeInterface), end_utc(DateTimeInterface)
        $method = $event['method'] ?? 'REQUEST';
        $sequence = (int)($event['sequence'] ?? 0);
        $status = $event['status'] ?? null;

        $dtstamp = (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format('Ymd\THis\Z');
        /** @var DateTimeInterface $startUtc */
        $startUtc = $event['start_utc'];
        /** @var DateTimeInterface $endUtc */
        $endUtc = $event['end_utc'];
        $dtstart = $startUtc->format('Ymd\THis\Z');
        $dtend = $endUtc->format('Ymd\THis\Z');

        $organizerName = $event['organizer_name'] ?? null;
        $organizer = 'ORGANIZER' . ($organizerName ? ';CN=' . self::escape($organizerName) : '') .
            ':MAILTO:' . $event['organizer_email'];

        $attendees = '';
        foreach (($event['attendees'] ?? []) as $att) {
            $email = is_array($att) ? ($att['email'] ?? $att[0] ?? null) : $att;
            if (!$email) {
                continue;
            }
            $name = is_array($att) ? ($att['name'] ?? $att[1] ?? null) : null;
            $attendees .= 'ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE'
                . ($name ? ';CN=' . self::escape($name) : '')
                . ':MAILTO:' . $email . "\r\n";
        }

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//LevelsAcademy//Calendar//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:' . $method,
            'BEGIN:VEVENT',
            'UID:' . $event['uid'],
            'DTSTAMP:' . $dtstamp,
            'DTSTART:' . $dtstart,
            'DTEND:' . $dtend,
            'SUMMARY:' . self::escape($event['summary'] ?? ''),
            'DESCRIPTION:' . self::escape($event['description'] ?? ''),
            $organizer,
        ];
        if ($status) {
            $lines[] = 'STATUS:' . $status;
        }
        if ($sequence > 0) {
            $lines[] = 'SEQUENCE:' . $sequence;
        }
        if ($attendees) {
            $lines[] = rtrim($attendees, "\r\n");
        }
        $lines[] = 'END:VEVENT';
        $lines[] = 'END:VCALENDAR';

        return implode("\r\n", $lines) . "\r\n";
    }
}

