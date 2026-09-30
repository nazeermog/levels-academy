<?php

namespace Tests\Unit;

use App\Support\WaAkgBot;
use Tests\TestCase;

class WaAkgBotTest extends TestCase
{
    public function test_it_returns_help_and_ping_responses_for_supported_commands(): void
    {
        $bot = new WaAkgBot();

        $this->assertStringContainsString('Yasmine Academy', $bot->replyFor('#help', '963955722868@s.whatsapp.net'));
        $this->assertStringContainsString('online', strtolower($bot->replyFor('#ping', '963955722868@s.whatsapp.net')));
    }
}
