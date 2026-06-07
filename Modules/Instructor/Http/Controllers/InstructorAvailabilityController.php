<?php

namespace Modules\Instructor\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\FreeSession\InstructorAvailability;

/**
 * Lets an instructor publish (and remove) the time slots they are available
 * for free trial sessions. The admin books these slots when assigning a
 * free-session request.
 */
class InstructorAvailabilityController extends Controller
{
    public function index()
    {
        $instructorId = Auth::id();
        $availabilities = InstructorAvailability::where('instructor_id', $instructorId)
            ->orderBy('start_at')
            ->get();

        return view('instructor::availability.index', compact('availabilities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slots'           => 'required|array|min:1',
            'slots.*.start'   => 'required|date',
            'slots.*.end'     => 'required|date',
        ]);

        // Convert provided local times to UTC (browser tz; fallback to app tz).
        $tz = (string) $request->input('tz', config('app.timezone', 'UTC'));
        if (!in_array($tz, timezone_identifiers_list(), true)) {
            $tz = config('app.timezone', 'UTC');
        }

        $instructorId = Auth::id();
        $created = 0;

        foreach ($data['slots'] as $slot) {
            $startUtc = Carbon::parse($slot['start'], $tz)->timezone('UTC');
            $endUtc   = Carbon::parse($slot['end'], $tz)->timezone('UTC');

            // Skip invalid ranges instead of failing the whole batch.
            if ($endUtc->lessThanOrEqualTo($startUtc)) {
                continue;
            }

            InstructorAvailability::create([
                'instructor_id' => $instructorId,
                'start_at'      => $startUtc,
                'end_at'        => $endUtc,
                'status'        => InstructorAvailability::STATUS_AVAILABLE,
            ]);
            $created++;
        }

        if ($created === 0) {
            return back()->withErrors(['error' => 'No valid time slots were added (end must be after start).'])->withInput();
        }

        return redirect()->route('instructor.availability.index')
            ->with('success', $created . ' availability slot(s) added.');
    }

    public function destroy(InstructorAvailability $availability)
    {
        if ((int) $availability->instructor_id !== (int) Auth::id()) {
            abort(403);
        }

        if ($availability->status === InstructorAvailability::STATUS_BOOKED) {
            return back()->withErrors(['error' => 'This slot is already booked and cannot be removed.']);
        }

        $availability->delete();

        return redirect()->route('instructor.availability.index')
            ->with('success', 'Availability slot removed.');
    }
}
