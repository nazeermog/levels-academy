<?php

namespace App\Http\Controllers\Api;

use App\Support\WaAkgBot;
use App\Support\WhatsApp;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class WaAkgBotWebhookController extends Controller
{
    public function handle(Request $request, WaAkgBot $bot, WhatsApp $whatsApp)
    {
        $data = $request->all();
        $event = $data['event'] ?? null;
        $message = $data['data']['content'] ?? $data['content'] ?? null;
        $from = $data['data']['from'] ?? $data['from'] ?? null;
        Log::info('[WA-AKG bot] incoming webhook', [
            'event' => $event,
            'from' => $from,
            'message' => $message,
        ]);

        if (!is_string($message) || trim($message) === '') {
            return response()->json(['ok' => true, 'ignored' => true]);
        }

        $reply = $bot->replyFor($message, $from);

        if ($from) {
            $whatsApp->sendText(
                preg_replace('/@.*$/', '', $from),
                $reply
            );
        }

        return response()->json([
            'ok' => true,
            'event' => $event,
            'reply' => $reply,
        ]);
    }
}
