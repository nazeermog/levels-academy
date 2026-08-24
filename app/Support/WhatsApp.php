<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Thin client for an OpenWA-compatible WhatsApp gateway (https://github.com/rmyndharis/OpenWA).
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
    /** Per-process cache of resolved session "name -> UUID" lookups. */
    private static array $sessionIdCache = [];

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

        $sessionId = $this->sessionPathId($base, $apiKey);
        if ($sessionId === null) {
            Log::warning('[WhatsApp] no usable session — skipping send', ['chatId' => $chatId]);
            return false;
        }

        try {
            $response = Http::withHeaders(['X-API-Key' => $apiKey])
                ->timeout(15)
                ->post("{$base}/api/sessions/{$sessionId}/messages/send-text", [
                    'chatId' => $chatId,
                    'text'   => $text,
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
     * Resolve the configured WHATSAPP_SESSION to the UUID the send route needs.
     *
     * OpenWA addresses a session by its UUID in the URL path, never by the friendly name. So if
     * WHATSAPP_SESSION is already a UUID we use it as-is; otherwise we treat it as the session
     * NAME and look its id up via GET /api/sessions (cached per process). This keeps the config
     * readable (`levels-academy`) and survives re-creating the session with the same name.
     */
    private function sessionPathId(string $base, string $apiKey): ?string
    {
        $configured = trim((string) config('services.whatsapp.session'));
        if ($configured === '') {
            return null;
        }

        // Already a UUID — the route wants exactly this.
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $configured)) {
            return $configured;
        }

        if (array_key_exists($configured, self::$sessionIdCache)) {
            return self::$sessionIdCache[$configured];
        }

        try {
            $response = Http::withHeaders(['X-API-Key' => $apiKey])
                ->timeout(10)
                ->get("{$base}/api/sessions");

            if (!$response->successful()) {
                Log::error('[WhatsApp] could not list sessions', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }

            $list = $response->json();
            $list = (is_array($list) && isset($list['data']) && is_array($list['data'])) ? $list['data'] : $list;
            foreach ((array) $list as $session) {
                if (is_array($session) && ($session['name'] ?? null) === $configured && !empty($session['id'])) {
                    return self::$sessionIdCache[$configured] = (string) $session['id'];
                }
            }

            Log::warning('[WhatsApp] session name not found on gateway — create it first', ['name' => $configured]);
            return null;
        } catch (\Throwable $e) {
            Log::error('[WhatsApp] session lookup failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Normalise a stored phone number to a WhatsApp chatId ("<international digits>@c.us").
     *
     * Handles the formats we store/receive:
     *   "09XXXXXXXX"      (local, seeded)   -> "<cc>9XXXXXXXX@c.us"
     *   "+963 93 182 3816" (international)  -> "96393182 3816" digits -> "963...@c.us"
     *   "0093..."         (00 intl prefix) -> stripped to "963...@c.us"
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

        return strlen($digits) >= 8 ? $digits . '@c.us' : null;
    }
}
