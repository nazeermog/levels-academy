<?php

namespace App\Support;

use DateTimeInterface;

/**
 * Builds "add to calendar" links from the same event array shape used by IcsBuilder.
 *
 * WhatsApp can't import an .ics the way an email client does, so instead of attaching a file
 * we drop a tappable Google Calendar link into the message — one tap opens a pre-filled event
 * that the recipient's phone renders in their own local time.
 */
class CalendarLink
{
    /**
     * Google Calendar "template" URL.
     *
     * Required event keys: summary, start_utc (DateTimeInterface), end_utc (DateTimeInterface).
     * Optional: description, location.
     */
    public static function google(array $event): string
    {
        /** @var DateTimeInterface $start */
        $start = $event['start_utc'];
        /** @var DateTimeInterface $end */
        $end = $event['end_utc'];

        $params = [
            'action' => 'TEMPLATE',
            'text'   => (string) ($event['summary'] ?? 'Session'),
            'dates'  => $start->format('Ymd\THis\Z') . '/' . $end->format('Ymd\THis\Z'),
        ];
        if (!empty($event['description'])) {
            $params['details'] = (string) $event['description'];
        }
        if (!empty($event['location'])) {
            $params['location'] = (string) $event['location'];
        }

        return 'https://calendar.google.com/calendar/render?' . http_build_query($params);
    }
}
