<?php

namespace Modules\Instructor\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\ClassSessionStudent;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSessionType;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Per-student payout for the logged-in instructor. Driven entirely by per-student
 * "given" records (class_session_student.is_given) — the instructor is credited
 * teacher_payout for each student they actually delivered a session to, NOT for
 * every enrolled student. Same source of truth as the Given Sessions history.
 */
class InstructorPayoutReportController extends Controller
{
    public function perStudent(Request $request)
    {
        return view('instructor::reports.per_student', $this->buildPayoutData($request));
    }

    public function perStudentPdf(Request $request)
    {
        $data = $this->buildPayoutData($request);

        $month = $data['month'];
        $data['monthLabel'] = $month ? Carbon::createFromFormat('Y-m', $month)->format('F Y') : null;

        $data['studentName'] = null;
        if (!empty($data['studentFilterId'])) {
            $sf = Student::find((int) $data['studentFilterId']);
            $data['studentName'] = $sf ? trim(($sf->first_name ?? '') . ' ' . ($sf->last_name ?? '')) : null;
        }
        $data['classroomName'] = !empty($data['classroomFilterId']) ? optional(Classroom::find((int) $data['classroomFilterId']))->name : null;
        $data['typeName'] = !empty($data['typeFilterId']) ? optional(ClassSessionType::find((int) $data['typeFilterId']))->name : null;

        $pdf = Pdf::loadView('instructor::reports.per_student_pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->download('per-student-payout-' . $month . '.pdf');
    }

    /**
     * Build the payout dataset from given per-student session records.
     */
    private function buildPayoutData(Request $request): array
    {
        $instructorId = Auth::id();
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $studentFilterId = $request->input('student_id');
        $typeFilterId = $request->input('class_session_type_id');
        $classroomFilterId = $request->input('classroom_id');
        $filtersApplied = $request->hasAny(['month', 'student_id', 'classroom_id', 'class_session_type_id']);

        // Every "given" per-student record for this instructor's normal sessions.
        $given = ClassSessionStudent::query()
            ->join('class_sessions', 'class_session_student.class_session_id', '=', 'class_sessions.id')
            ->where('class_sessions.instructor_id', $instructorId)
            ->where('class_sessions.type', ClassSession::TYPE_NORMAL)
            ->where('class_session_student.is_given', true)
            ->when(!empty($classroomFilterId), fn ($q) => $q->where('class_sessions.classroom_id', $classroomFilterId))
            ->when(!empty($typeFilterId), fn ($q) => $q->where('class_sessions.class_session_type_id', $typeFilterId))
            ->when(!empty($month), function ($q) use ($month) {
                $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
                $end = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
                $q->whereBetween('class_sessions.held_at', [$start, $end]);
            })
            ->with(['session.sessionType', 'session.classroom', 'studentUser'])
            ->select('class_session_student.*')
            ->get();

        // Per-session detail (one row per given session).
        $sessionsDetailed = $given->groupBy('class_session_id')->map(function ($rows) {
            $session = $rows->first()->session;
            $payout = (float) (optional(optional($session)->sessionType)->teacher_payout ?? 0);
            $price = (float) (optional(optional($session)->sessionType)->price ?? 0);
            $participantIds = $rows->pluck('student_id')->map(fn ($v) => (int) $v)->unique()->values()->all();
            $count = count($participantIds);

            return [
                'id' => (int) $rows->first()->class_session_id,
                'held_at' => optional($session)->held_at,
                'classroom' => optional(optional($session)->classroom)->name,
                'type' => optional(optional($session)->sessionType)->name,
                'teacher_payout' => $payout,
                'revenue' => $price * $count,          // each given student was charged the price
                'participants_count' => $count,        // students the session was given to
                'per_student_share' => $payout,        // instructor earns full payout per given student
                'participant_ids' => $participantIds,
            ];
        })->values();

        // Per-student totals: teacher_payout summed over the sessions given to them.
        $rows = $given->groupBy('student_id')->map(function ($rows, $sid) {
            return [
                'student_id' => (int) $sid,
                'sessions_count' => $rows->pluck('class_session_id')->unique()->count(),
                'amount' => $rows->sum(fn ($r) => (float) (optional(optional($r->session)->sessionType)->teacher_payout ?? 0)),
            ];
        })->values();

        $students = Student::whereIn('user_id', $rows->pluck('student_id'))->get()->keyBy('user_id');
        $rows = $rows->map(function ($r) use ($students) {
            $r['student'] = $students->get($r['student_id']);
            return $r;
        })->sortByDesc('amount')->values();

        // Filter dropdown options.
        $studentsForFilter = Student::whereIn('user_id', $given->pluck('student_id')->map(fn ($v) => (int) $v)->unique())->get()->keyBy('user_id');
        $classroomsForFilter = Classroom::where('instructor_id', $instructorId)->orderBy('name')->get()->keyBy('id');
        $typesForFilter = ClassSessionType::orderBy('name')->get()->keyBy('id');

        // Apply the student filter to the displayed rows/details.
        if (!empty($studentFilterId)) {
            $rows = $rows->where('student_id', (int) $studentFilterId)->values();
            $sessionsDetailed = $sessionsDetailed
                ->filter(fn ($s) => in_array((int) $studentFilterId, $s['participant_ids'] ?? [], true))
                ->values();
        }

        return [
            'table_name' => 'Per-Student Payout',
            'month' => $month,
            'studentFilterId' => $studentFilterId,
            'typeFilterId' => $typeFilterId,
            'classroomFilterId' => $classroomFilterId,
            'filtersApplied' => $filtersApplied,
            'rows' => $rows,
            'sessionsCount' => $sessionsDetailed->count(),
            'grandTotal' => $rows->sum('amount'),
            'sessionsDetailed' => $sessionsDetailed,
            'studentsForFilter' => $studentsForFilter,
            'classroomsForFilter' => $classroomsForFilter,
            'typesForFilter' => $typesForFilter,
        ];
    }
}
