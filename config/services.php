<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
     | WhatsApp gateway (OpenWA-compatible HTTP API). Session notifications to
     | parents are sent as WhatsApp messages instead of calendar emails.
     |
     |  - base_url:     where the gateway runs (Docker or a plain Node process).
     |  - session:      the gateway session name linked to the Academy's number.
     |  - country_code: default dialing code used to normalise local numbers
     |                  (Syria = 963); a stored "09XXXXXXXX" becomes "9639XXXXXXXX".
     |
     | When `enabled` is false or no api_key is set, sends are logged-and-skipped
     | so dev/local (no gateway running) never errors.
     */
    'whatsapp' => [
        'enabled'      => env('WHATSAPP_ENABLED', false),
        'base_url'     => env('WHATSAPP_API_URL', 'http://localhost:2785'),
        'api_key'      => env('WHATSAPP_API_KEY'),
        'session'      => env('WHATSAPP_SESSION', 'levels-academy'),
        'country_code' => env('WHATSAPP_COUNTRY_CODE', '963'),
        // While set, EVERY message is redirected to this number instead of the real
        // parent — for testing without messaging families. Leave empty in production.
        'test_to'      => env('WHATSAPP_TEST_TO'),
    ],

];
