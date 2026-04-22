<?php

namespace Modules\Instructor\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Classroom\Classroom;

class ExpectedEarningsReportController extends Controller
{
    /**
     * Display the expected payout report for the logged-in instructor.
     *
     * Projects earnings from the classroom schedule (repeats_per_week)
     * so it works even for months with no sessions created yet.
     */
    public function index(Request $request)
    {
        $instructorId = Auth::id();
        $month        = $request->input('month', Carbon::now()->format('Y-m'));
        $classroomId  = $request->input('classroom_id');
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth   = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        // ── Fetch classrooms assigned to this instructor ──
        $classroomsQuery = Classroom::with(['defaultSessionType'])
            ->where('instructor_id', $instructorId)
            ->whereNotNull('class_session_type_id')
            ->when(!empty($classroomId), fn ($q) => $q->where('id', $classroomId));

        $classroomRows = $classroomsQuery->orderBy('name')->get();

        // ── Build projection per classroom ──
        $rows = $classroomRows->map(function ($classroom) use ($startOfMonth, $endOfMonth) {
            $sessionType       = $classroom->defaultSessionType;
            $payoutPerSession  = (float) (optional($sessionType)->teacher_payout ?? 0);
            $enrolledStudents  = $classroom->students()->count();
            $projectedSessions = $this->countProjectedSessions($classroom, $startOfMonth, $endOfMonth);

            return [
                'classroom'          => $classroom,
                'session_type'       => $sessionType,
                'enrolled_students'  => $enrolledStudents,
                'sessions_count'     => $projectedSessions,
                'payout_per_session' => $payoutPerSession,
                'expected_payout'    => $payoutPerSession * $enrolledStudents * $projectedSessions,
            ];
        })->sortByDesc('expected_payout')->values();

        // ── Totals ──
        $totalSessions = $rows->sum('sessions_count');
        $totalPayout   = $rows->sum('expected_payout');

        // ── Dropdown data ──
        $classrooms = Classroom::where('instructor_id', $instructorId)
            ->orderBy('name')
            ->get();

        return view('instructor::reports.expected_earnings', compact(
            'month',
            'classroomId',
            'rows',
            'totalSessions',
            'totalPayout',
            'classrooms'
        ));
    }

    /**
     * Count how many sessions are projected for a classroom in the given month,
     * based on its days_of_week and repeats_per_week configuration.
     */
    private function countProjectedSessions(Classroom $classroom, Carbon $startOfMonth, Carbon $endOfMonth): int
    {
        $perWeek = (int) $classroom->repeats_per_week;
        if ($perWeek <= 0) {
            return 0;
        }

        $daysCsv = (string) $classroom->days_of_week;
        $days    = array_values(array_filter(
            array_map('intval', explode(',', $daysCsv)),
            fn ($v) => $v >= 1 && $v <= 7
        ));

        // If specific weekdays are configured, count how many of those days fall in the month
        if (!empty($days)) {
            $count = 0;
            $cursor = $startOfMonth->copy();
            while ($cursor->lte($endOfMonth)) {
                if (in_array($cursor->dayOfWeekIso, $days, true)) {
                    $count++;
                }
                $cursor->addDay();
            }
            return $count;
        }

        // Fallback: repeats_per_week × number of weeks overlapping the month
        $weeksInMonth = $startOfMonth->diffInWeeks($endOfMonth->copy()->addDay());
        return $perWeek * max(1, (int) $weeksInMonth);
    }
}
