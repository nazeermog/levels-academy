<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataSource\Entities\FreeSession\FreeSessionRequest;

/**
 * External (Passport) API for requesting a free trial session.
 *
 * Endpoints (prefix: /api/free-sessions, guard: auth:api):
 *   GET    /                 -> the current user's free-session requests
 *   POST   /                 -> create a new request (joins the waiting list)
 *   DELETE /{freeSession}    -> cancel the user's own still-pending request
 *
 * The user only requests; an admin later assigns an instructor + time slot.
 */
class FreeSessionApiController extends Controller
{
    public function index(Request $request)
    {
        $requests = FreeSessionRequest::where('user_id', $request->user()->id)
            ->with(['instructor:id,first_name,last_name'])
            ->latest('id')
            ->get();

        return response()->json(['data' => $requests]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        // One open request at a time.
        $existing = FreeSessionRequest::where('user_id', $request->user()->id)
            ->where('status', FreeSessionRequest::STATUS_PENDING)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'You already have a pending free-session request.',
                'data'    => $existing,
            ], 409);
        }

        $freeSession = FreeSessionRequest::create([
            'user_id' => $request->user()->id,
            'note'    => $data['note'] ?? null,
            'status'  => FreeSessionRequest::STATUS_PENDING,
        ]);

        return response()->json([
            'message' => 'Free-session request submitted. You will be notified once it is scheduled.',
            'data'    => $freeSession,
        ], 201);
    }

    public function destroy(Request $request, FreeSessionRequest $freeSession)
    {
        if ((int) $freeSession->user_id !== (int) $request->user()->id) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        if ($freeSession->status !== FreeSessionRequest::STATUS_PENDING) {
            return response()->json([
                'message' => 'Only pending requests can be cancelled.',
            ], 422);
        }

        $freeSession->update(['status' => FreeSessionRequest::STATUS_CANCELLED]);

        return response()->json(['message' => 'Request cancelled.']);
    }
}
