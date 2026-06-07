<?php

namespace Modules\Instructor\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Transaction\Transaction;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSessionType;
use Barryvdh\DomPDF\Facade\Pdf;

class InstructorPayoutReportController extends Controller
{
    public function perStudent(Request $request)
    {
        $instructorId = Auth::id(); // users.id
        $month = $request->input('month'); // if null => all time
        $studentFilterId = $request->input('student_id');
        $typeFilterId = $request->input('class_session_type_id');
        $classroomFilterId = $request->input('classroom_id');
        $filtersApplied = $request->hasAny(['month', 'student_id', 'classroom_id', 'class_session_type_id']);

        // Sessions taught by this instructor in the month
        $sessions = ClassSession::normal()->with(['type', 'classroom'])
            ->where('instructor_id', $instructorId)
            ->when(!empty($classroomFilterId), function ($q) use ($classroomFilterId) {
                $q->where('classroom_id', $classroomFilterId);
            })
            ->when(!empty($typeFilterId), function ($q) use ($typeFilterId) {
                $q->where('class_session_type_id', $typeFilterId);
            })
            ->when(!empty($month), function ($q) use ($month) {
                $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
                $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
                $q->whereBetween('held_at', [$startOfMonth, $endOfMonth]);
            })
            ->get();

        $sessionIds = $sessions->pluck('id')->all();
        if (empty($sessionIds)) {
            return view('instructor::reports.per_student', [
                'table_name' => 'Per-Student Payout',
                'month' => $month,
                'studentFilterId' => $studentFilterId,
                'typeFilterId' => $typeFilterId,
                'classroomFilterId' => $classroomFilterId,
                'filtersApplied' => $filtersApplied,
                'rows' => collect(),
                'sessionsCount' => 0,
                'grandTotal' => 0,
                'sessionsDetailed' => collect(),
                'studentsForFilter' => collect(),
                'classroomsForFilter' => collect(),
                'typesForFilter' => collect(),
            ]);
        }

        // All transactions this month (charges only)
        $monthlyTx = Transaction::query()
            ->when(!empty($month), function ($q) use ($month) {
                $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
                $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            })
            ->where('is_credit', 0)
            ->get();

        // Group transactions by session id (parsed from desc)
        $txBySession = $monthlyTx->mapWithKeys(function ($t) {
            if (!is_string($t->desc)) {
                return [null => null];
            }
            if (preg_match('/Class session #(\d+)/i', $t->desc, $m)) {
                return [(int) $m[1] => $t];
            }
            return [null => null];
        })->filter(function ($v, $k) {
            return $k !== null;
        })->groupBy(function ($t, $sid) {
            return $sid;
        });

        // Build session details for UI
        $sessionsDetailed = $sessions->map(function ($session) use ($txBySession) {
            $sid = $session->id;
            $payout = (float) (optional($session->type)->teacher_payout ?? 0);
            $txForSession = $txBySession->get($sid, collect());
            $revenue = $txForSession->sum('price'); // only charges were included in $monthlyTx

            // charged participants
            $chargedStudentIds = $txForSession->pluck('student_id')->filter()->unique()->values()->all();

            // fallback participants (enrolled) if none charged
            $fallbackStudentIds = [];
            if (empty($chargedStudentIds) && $session->classroom) {
                $fallbackStudentIds = $session->classroom->students()->pluck('users.id')->toArray();
            }

            $participantsCount = count($chargedStudentIds) > 0 ? count($chargedStudentIds) : count($fallbackStudentIds);
            $perStudentShare = $participantsCount > 0 ? $payout / $participantsCount : 0.0;
            $participantIds = count($chargedStudentIds) > 0 ? $chargedStudentIds : $fallbackStudentIds;

            return [
                'id' => $sid,
                'held_at' => $session->held_at,
                'classroom' => optional($session->classroom)->name,
                'type' => optional($session->type)->name,
                'teacher_payout' => $payout,
                'revenue' => $revenue,
                'participants_count' => $participantsCount,
                'per_student_share' => $perStudentShare,
                'participant_ids' => $participantIds,
            ];
        })->values();

        // Build dropdown options for student filter
        $allParticipantIds = $sessionsDetailed->flatMap(function ($s) {
            return $s['participant_ids'] ?? [];
        })->filter()->unique()->values();
        $studentsForFilter = Student::whereIn('user_id', $allParticipantIds)->get()->keyBy('user_id');
        $classroomsForFilter = Classroom::where('instructor_id', $instructorId)->orderBy('name')->get()->keyBy('id');
        $typesForFilter = ClassSessionType::orderBy('name')->get()->keyBy('id');

        // Build per-student totals by allocating each session's teacher_payout
        // equally among participating students. If no transactions exist for a
        // session (e.g., generated by scheduler), fall back to classroom enrolled students.
        $studentTotals = [];
        $studentSessions = []; // track distinct session ids per student

        foreach ($sessions as $session) {
            $sid = $session->id;
            $payout = (float) (optional($session->type)->teacher_payout ?? 0);

            $txForSession = $txBySession->get($sid, collect());

            // Determine participating students
            if ($txForSession->count() > 0) {
                $participantIds = $txForSession->pluck('student_id')->filter()->unique()->values()->all();
            } else {
                // Fallback to classroom enrolled students (users.id)
                $participantIds = [];
                if ($session->classroom) {
                    $participantIds = $session->classroom->students()->pluck('users.id')->toArray();
                }
            }

            if (empty($participantIds)) {
                // No participants to allocate to
                continue;
            }

            $numStudents = max(1, count($participantIds));
            $share = $payout > 0 ? ($payout / $numStudents) : 0.0;

            foreach ($participantIds as $stuId) {
                if (!$stuId) { continue; }

                if (!isset($studentTotals[$stuId])) {
                    $studentTotals[$stuId] = 0.0;
                    $studentSessions[$stuId] = [];
                }
                $studentTotals[$stuId] += $share;
                $studentSessions[$stuId][$sid] = true; // ensure distinct count
            }
        }

        $studentIds = array_keys($studentTotals);
        $students = Student::whereIn('user_id', $studentIds)->get()->keyBy('user_id');

        $rows = collect($studentIds)->map(function ($sid) use ($students, $studentTotals, $studentSessions) {
            return [
                'student' => $students->get($sid),
                'student_id' => $sid,
                'sessions_count' => isset($studentSessions[$sid]) ? count($studentSessions[$sid]) : 0,
                'amount' => $studentTotals[$sid] ?? 0.0,
            ];
        })->sortByDesc('amount')->values();

        // Apply student filter if provided
        if (!empty($studentFilterId)) {
            $rows = $rows->where('student_id', (int) $studentFilterId)->values();
            $sessionsDetailed = $sessionsDetailed->filter(function ($s) use ($studentFilterId) {
                return in_array((int) $studentFilterId, $s['participant_ids'] ?? [], true);
            })->values();
        }

        $sessionsCount = $sessions->count();
        $grandTotal = $rows->sum('amount');

        $table_name = 'Per-Student Payout';
        return view('instructor::reports.per_student', compact(
            'table_name',
            'month',
            'rows',
            'sessionsCount',
            'grandTotal',
            'sessionsDetailed',
            'studentsForFilter',
            'studentFilterId',
            'typesForFilter',
            'classroomsForFilter',
            'typeFilterId',
            'classroomFilterId',
            'filtersApplied'
        ));
    }

    public function perStudentPdf(Request $request)
    {
        // Reuse the same data building as perStudent
        $instructorId = Auth::id();
        $month = $request->input('month'); // if null => all time
        $studentFilterId = $request->input('student_id');
        $typeFilterId = $request->input('class_session_type_id');
        $classroomFilterId = $request->input('classroom_id');

        $sessions = ClassSession::normal()->with(['type', 'classroom'])
            ->where('instructor_id', $instructorId)
            ->when(!empty($classroomFilterId), fn($q) => $q->where('classroom_id', $classroomFilterId))
            ->when(!empty($typeFilterId), fn($q) => $q->where('class_session_type_id', $typeFilterId))
            ->when(!empty($month), function ($q) use ($month) {
                $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
                $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
                $q->whereBetween('held_at', [$startOfMonth, $endOfMonth]);
            })
            ->get();

        $sessionIds = $sessions->pluck('id')->all();
        $sessionsCount = $sessions->count();

        $monthlyTx = Transaction::query()
            ->when(!empty($month), function ($q) use ($month) {
                $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
                $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            })
            ->where('is_credit', 0)
            ->get();

        $txBySession = $monthlyTx->mapWithKeys(function ($t) {
            if (!is_string($t->desc)) return [null => null];
            if (preg_match('/Class session #(\d+)/i', $t->desc, $m)) return [(int)$m[1] => $t];
            return [null => null];
        })->filter(fn($v, $k) => $k !== null)->groupBy(fn($t, $sid) => $sid);

        $sessionsDetailed = $sessions->map(function ($session) use ($txBySession) {
            $sid = $session->id;
            $payout = (float) (optional($session->type)->teacher_payout ?? 0);
            $txForSession = $txBySession->get($sid, collect());
            $revenue = $txForSession->sum('price');
            $chargedStudentIds = $txForSession->pluck('student_id')->filter()->unique()->values()->all();
            $fallbackStudentIds = [];
            if (empty($chargedStudentIds) && $session->classroom) {
                $fallbackStudentIds = $session->classroom->students()->pluck('users.id')->toArray();
            }
            $participantsCount = count($chargedStudentIds) > 0 ? count($chargedStudentIds) : count($fallbackStudentIds);
            $perStudentShare = $participantsCount > 0 ? $payout / $participantsCount : 0.0;
            $participantIds = count($chargedStudentIds) > 0 ? $chargedStudentIds : $fallbackStudentIds;
            return [
                'id' => $sid,
                'held_at' => $session->held_at,
                'classroom' => optional($session->classroom)->name,
                'type' => optional($session->type)->name,
                'teacher_payout' => $payout,
                'revenue' => $revenue,
                'participants_count' => $participantsCount,
                'per_student_share' => $perStudentShare,
                'participant_ids' => $participantIds,
            ];
        })->values();

        $allParticipantIds = $sessionsDetailed->flatMap(fn($s) => $s['participant_ids'] ?? [])->filter()->unique()->values();
        $studentsForFilter = Student::whereIn('user_id', $allParticipantIds)->get()->keyBy('user_id');
        $classroomsForFilter = Classroom::where('instructor_id', $instructorId)->orderBy('name')->get()->keyBy('id');
        $typesForFilter = ClassSessionType::orderBy('name')->get()->keyBy('id');

        $studentTotals = [];
        $studentSessions = [];
        foreach ($sessions as $session) {
            $sid = $session->id;
            $payout = (float) (optional($session->type)->teacher_payout ?? 0);
            $txForSession = $txBySession->get($sid, collect());
            if ($txForSession->count() > 0) {
                $participantIds = $txForSession->pluck('student_id')->filter()->unique()->values()->all();
            } else {
                $participantIds = [];
                if ($session->classroom) {
                    $participantIds = $session->classroom->students()->pluck('users.id')->toArray();
                }
            }
            if (empty($participantIds)) continue;
            $numStudents = max(1, count($participantIds));
            $share = $payout > 0 ? ($payout / $numStudents) : 0.0;
            foreach ($participantIds as $stuId) {
                if (!$stuId) continue;
                if (!isset($studentTotals[$stuId])) {
                    $studentTotals[$stuId] = 0.0;
                    $studentSessions[$stuId] = [];
                }
                $studentTotals[$stuId] += $share;
                $studentSessions[$stuId][$sid] = true;
            }
        }
        $studentIds = array_keys($studentTotals);
        $students = Student::whereIn('user_id', $studentIds)->get()->keyBy('user_id');
        $rows = collect($studentIds)->map(function ($sid) use ($students, $studentTotals, $studentSessions) {
            return [
                'student' => $students->get($sid),
                'student_id' => $sid,
                'sessions_count' => isset($studentSessions[$sid]) ? count($studentSessions[$sid]) : 0,
                'amount' => $studentTotals[$sid] ?? 0.0,
            ];
        })->sortByDesc('amount')->values();
        if (!empty($studentFilterId)) {
            $rows = $rows->where('student_id', (int) $studentFilterId)->values();
            $sessionsDetailed = $sessionsDetailed->filter(function ($s) use ($studentFilterId) {
                return in_array((int) $studentFilterId, $s['participant_ids'] ?? [], true);
            })->values();
        }
        $grandTotal = $rows->sum('amount');
        $table_name = 'Per-Student Payout';

        $monthLabel = $month ? Carbon::createFromFormat('Y-m', $month)->format('F Y') : null;
        $studentName = null;
        if (!empty($studentFilterId)) {
            $sf = Student::find((int)$studentFilterId);
            if ($sf) { $studentName = trim(($sf->first_name ?? '').' '.($sf->last_name ?? '')); }
        }
        $classroomName = null;
        if (!empty($classroomFilterId)) {
            $cf = Classroom::find((int)$classroomFilterId);
            $classroomName = $cf?->name;
        }
        $typeName = null;
        if (!empty($typeFilterId)) {
            $tf = ClassSessionType::find((int)$typeFilterId);
            $typeName = $tf?->name;
        }

        $pdf = Pdf::loadView('instructor::reports.per_student_pdf', compact(
            'table_name','month','rows','sessionsCount','grandTotal','sessionsDetailed',
            'monthLabel','studentName','classroomName','typeName'
        ))->setPaper('a4', 'portrait');
        $filename = 'per-student-payout-'.$month.'.pdf';
        return $pdf->download($filename);
    }

}



