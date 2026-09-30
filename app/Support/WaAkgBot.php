<?php

namespace App\Support;

class WaAkgBot
{
    /**
     * Generate a text reply for a WA-AKG bot command.
     * This is intentionally lightweight and keeps the bot useful for:
     * - #help
     * - #ping
     * - #whoami
     * - #status
     */
    public function replyFor(string $message, ?string $from = null): string
    {
        $text = trim((string) $message);
        $normalized = strtolower($text);

        if ($normalized === '#help' || $normalized === '!help') {
            return "Yasmine Academy bot\n\nCommands:\n#help - show this message\n#ping - check bot status\n#whoami - show sender info\n#status - show academy status\n\nThis bot is connected to the academy WhatsApp number and helps answer quick messages automatically.";
        }

        if ($normalized === '#ping' || $normalized === '!ping') {
            return 'Pong! Yasmine Academy bot is online and ready.';
        }

        if ($normalized === '#whoami' || $normalized === '!whoami') {
            $from = $from ?: 'unknown number';
            return "You are messaging from: {$from}\n\nThis is the Yasmine Academy WhatsApp bot.";
        }

        if ($normalized === '#status' || $normalized === '!status') {
            return "Yasmine Academy status: online\nClass reminders are active\nDaily summaries are enabled\nSupport bot is ready.";
        }

        return "Hello! I am the Yasmine Academy bot. Send #help to see available commands.";
    }
}
