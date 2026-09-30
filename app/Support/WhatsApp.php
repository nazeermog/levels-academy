<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Thin client for the WA-AKG WhatsApp gateway.
 *
 * The gateway is a separate always-on service (Docker OR a plain Node process) linked to the
 * Academy's own WhatsApp number. We only talk to it over HTTP, so this app never bundles a
 * WhatsApp library and doesn't care which number is linked — that's an ops/config concern.
 *
 * Sending is best-effort: any misconfiguration or transport failure is logged and swallowed so
 * it can never break the request that triggered the notification (session creation, etc.).
 */
class WhatsApp
{
    /**
     * Send a plain-text WhatsApp message. Returns true only on a successful gateway response.
     */
    public function sendText(string $phone, string $text): bool
    {
        if (!config('services.whatsapp.enabled')) {
            Log::info('[WhatsApp] disabled — skipping send', ['phone' => $phone]);
            return false;
        }

        // Test override: while WHATSAPP_TEST_TO is set, redirect every message to that
        // number so notifications can be verified without messaging real families.
        $testTo = (string) config('services.whatsapp.test_to');
        if ($testTo !== '') {
            Log::info('[WhatsApp] test mode — redirecting message', ['intended' => $phone, 'test_to' => $testTo]);
            $phone = $testTo;
        }

        $chatId = $this->chatIdFor($phone);
        if ($chatId === null) {
            Log::warning('[WhatsApp] unusable phone number — skipping', ['phone' => $phone]);
            return false;
        }

        $base    = rtrim((string) config('services.whatsapp.base_url'), '/');
        $apiKey  = (string) config('services.whatsapp.api_key');

        if ($apiKey === '') {
            Log::warning('[WhatsApp] no api key configured — skipping send', ['chatId' => $chatId]);
            return false;
        }

        $sessionId = trim((string) config('services.whatsapp.session'));
        if ($sessionId === '') {
            Log::warning('[WhatsApp] no usable session — skipping send', ['chatId' => $chatId]);
            return false;
        }

        try {
            $response = Http::withHeaders(['X-API-Key' => $apiKey])
                ->timeout(15)
                ->post("{$base}/api/messages/" . rawurlencode($sessionId) . '/' . rawurlencode($chatId) . '/send', [
                    'message' => [
                        'text' => $text,
                    ],
                ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('[WhatsApp] gateway rejected message', [
                'chatId' => $chatId,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('[WhatsApp] send failed', [
                'chatId' => $chatId,
                'error'  => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Normalise a stored phone number to a WhatsApp JID ("<international digits>@s.whatsapp.net").
     *
     * Handles the formats we store/receive:
     *   "09XXXXXXXX"      (local, seeded)   -> "<cc>9XXXXXXXX@s.whatsapp.net"
     *   "+963 93 182 3816" (international)  -> "963...@s.whatsapp.net"
     *   "0093..."         (00 intl prefix) -> stripped to "963...@s.whatsapp.net"
     *   "93XXXXXXXX"      (national, no 0)  -> prefixed with the country code
     *
     * Returns null when there aren't enough digits to be a real number.
     */
    public function chatIdFor(string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if ($digits === '') {
            return null;
        }

        $cc = (string) config('services.whatsapp.country_code', '963');

        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);            // drop the 00 international prefix
        }
        if (str_starts_with($digits, '0')) {
            $digits = $cc . substr($digits, 1);      // local 0-prefixed -> add country code
        } elseif (!str_starts_with($digits, $cc)) {
            $digits = $cc . $digits;                 // bare national number -> add country code
        }

        return strlen($digits) >= 8 ? $digits . '@s.whatsapp.net' : null;
    }
}
