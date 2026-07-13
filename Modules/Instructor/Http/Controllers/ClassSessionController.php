<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\ClassSessionType;
use DataSource\Entities\Classroom\ClassSessionStudent;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Transaction\Transaction;
use DataSource\Entities\User\User;
use Illuminate\Support\Facades\DB;
use App\Support\IcsBuilder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendSessionInvite;

class ClassSessionController extends Controller
{
    /** Calendar event colours. */
    private const COLOR_GIVEN = '#28a745';   // session already given / done
    private const COLOR_TO_GIVE = '#fd7e14'; // session still to be given

    public function index()
    {
        // The view renders a calendar; sessions are loaded via the events() feed.
        return view('instructor::classrooms.sessions.index');
    }

    /**
     * JSON feed of this instructor's class sessions for the calendar.
     */
    public function events()
    {
        $sessions = ClassSession::normal()
            ->with(['classroom', 'sessionType'])
            ->where('instructor_id', Auth::id())
            ->get();

        $events = $sessions->map(fn (ClassSession $session) => $this->toCalendarEvent($session));

        return response()->json($events);
    }

    public function create()
    {
        $instructorId = Auth::id();
        $classrooms = Classroom::where('instructor_id', $instructorId)->orderBy('name')->get();
        $orgId = optional($classrooms->first())->organization_id;
        $types = ClassSessionType::when($orgId, fn($q) => $q->inOrganization($orgId))
            ->orderBy('name')
            ->get();

        return view('instructor::classrooms.sessions.create', compact('classrooms', 'types'));
    }

    public function edit(ClassSession $session)
    {
        $this->authorizeOwnership($session);

        return view('instructor::classrooms.sessions.edit', compact('session'));
    }

    public function update(Request $request, ClassSession $session)
    {
        $this->authorizeOwnership($session);

        $data = $request->validate([
            'content' => 'nullable|string',
            'is_given' => 'nullable|boolean',
            'zoom_url' => 'nullable|url',
        ]);

        $session->update([
            'content' => $data['content'] ?? null,
            'is_given' => (bool) ($data['is_given'] ?? false),
            'zoom_url' => $data['zoom_url'] ?? null,
        ]);

        return redirect()->route('instructor.sessions.index')->with('success', 'Session updated.');
    }

    public function store(Request $request)
    {
        $instructorId = (int) Auth::id();
        $data = $this->validateStore($request);

        $classroom = Classroom::findOrFail($data['classroom_id']);
        $this->authorizeClassroomOwnership($classroom, $instructorId);

        $tz = $this->resolveTimezone($request);

        DB::beginTransaction();
        try {
            $session = $this->createSession($data, $classroom, $instructorId, $tz);

            $studentUserIds = $classroom->students()->pluck('users.id')->toArray();

            // Per-student model: create a pending record for each enrolled student.
            // Parents are NOT charged here — billing happens when the instructor
            // marks each student's session as given (see markStudentGiven()).
            $this->createAttendances($session, $studentUserIds);
            $this->sendInvites($classroom, $session, $studentUserIds, $instructorId);

            DB::commit();

            return redirect()->route('instructor.sessions.attendance', $session->id)
                ->with('success', 'Session saved. Mark each student as given when the session is delivered.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /* ----------------------------------------------------------------------
     | Per-student attendance + billing at "given" time
     * -------------------------------------------------------------------- */

    /**
     * Roster for a session: each enrolled student with given/notes/charged state.
     */
    public function attendance(ClassSession $session)
    {
        $this->authorizeOwnership($session);
        $session->load(['classroom', 'sessionType']);

        // Make sure every current classroom student has a row (covers students
        // enrolled into the classroom after the session was created).
        if ($session->classroom) {
            $this->createAttendances($session, $session->classroom->students()->pluck('users.id')->toArray());
        }

        $rows = ClassSessionStudent::where('class_session_id', $session->id)->get();
        $students = User::whereIn('id', $rows->pluck('student_id'))->get()->keyBy('id');

        return view('instructor::classrooms.sessions.attendance', compact('session', 'rows', 'students'));
    }

    /**
     * Mark one student's session as given (+ note). On the first time given, charge
     * that student's parent and credit the instructor (idempotent via `charged`).
     */
    public function markStudentGiven(Request $request, ClassSession $session, $studentId)
    {
        $this->authorizeOwnership($session);

        $data = $request->validate(['notes' => 'nullable|string|max:2000']);

        $attendance = ClassSessionStudent::where('class_session_id', $session->id)
            ->where('student_id', (int) $studentId)
            ->firstOrFail();

        DB::beginTransaction();
        try {
            $attendance->is_given = true;
            $attendance->notes = $data['notes'] ?? $attendance->notes;
            $attendance->given_at = $attendance->given_at ?? now();

            if (!$attendance->charged) {
                $tx = $this->chargeForAttendance($session, (int) $studentId);
                if ($tx) {
                    $attendance->transaction_id = $tx->id;
                    $attendance->charged = true;
                }
            }

            $attendance->save();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return back()->with('success', 'Session marked as given for the student.');
    }

    /**
     * History of every session this instructor has marked given, per student,
     * with the earning (teacher_payout) per row and a running total.
     */
    public function history()
    {
        $instructorId = (int) Auth::id();

        $base = ClassSessionStudent::query()
            ->join('class_sessions', 'class_session_student.class_session_id', '=', 'class_sessions.id')
            ->where('class_sessions.instructor_id', $instructorId)
            ->where('class_session_student.is_given', true);

        $rows = (clone $base)
            ->with(['session.classroom', 'session.sessionType', 'studentUser'])
            ->orderByDesc('class_session_student.given_at')
            ->select('class_session_student.*')
            ->paginate(30);

        // Total earned across ALL given rows (not just the current page).
        $totalEarned = (clone $base)
            ->with('session.sessionType')
            ->select('class_session_student.*')
            ->get()
            ->sum(fn ($r) => (float) optional(optional($r->session)->sessionType)->teacher_payout);

        return view('instructor::classrooms.sessions.history', compact('rows', 'totalEarned'));
    }

    /**
     * Create pending per-student records for the given student user ids (idempotent).
     */
    private function createAttendances(ClassSession $session, array $studentUserIds): void
    {
        foreach ($studentUserIds as $studentUserId) {
            if (!$studentUserId) {
                continue;
            }
            ClassSessionStudent::firstOrCreate(
                ['class_session_id' => $session->id, 'student_id' => (int) $studentUserId],
                ['is_given' => false, 'charged' => false]
            );
        }
    }

    /**
     * Charge one student's parent the session price (and thereby credit the
     * instructor — payout reports derive from these charge transactions).
     * Description mirrors the format the reports parse ("Class session #<id>").
     */
    private function chargeForAttendance(ClassSession $session, int $studentUserId): ?Transaction
    {
        $type = $session->sessionType;
        if (!$type) {
            return null;
        }
        $student = Student::find($studentUserId);
        if (!$student) {
            return null;
        }
        $parent = $student->parentts()->first();
        if (!$parent) {
            return null;
        }

        return Transaction::create([
            'parent_id'  => $parent->user_id,
            'course_id'  => 0,
            'student_id' => $student->user_id,
            'price'      => $type->price,
            'type'       => 'once',
            'is_credit'  => 0,
            'desc'       => 'Class session #'.$session->id.' charge: '.$type->name,
        ]);
    }

    /* ----------------------------------------------------------------------
     | Calendar
     * -------------------------------------------------------------------- */

    /**
     * Map a session to a FullCalendar event.
     */
    private function toCalendarEvent(ClassSession $session): array
    {
        $classroomName = optional($session->classroom)->name ?: 'Session';
        $typeName = optional($session->sessionType)->name;
        $color = $session->is_given ? self::COLOR_GIVEN : self::COLOR_TO_GIVE;

        return [
            'id' => $session->id,
            'title' => $typeName ? $classroomName.' · '.$typeName : $classroomName,
            'start' => optional($session->held_at)->toIso8601String(),
            'end' => $session->end_at ? $session->end_at->toIso8601String() : null,
            'url' => route('instructor.sessions.edit', $session->id),
            'backgroundColor' => $color,
            'borderColor' => $color,
            'extendedProps' => [
                'is_given' => (bool) $session->is_given,
            ],
        ];
    }

    /* ----------------------------------------------------------------------
     | Store helpers
     * -------------------------------------------------------------------- */

    private function validateStore(Request $request): array
    {
        return $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'held_at' => 'required|date',
            'end_at' => 'required|date|after:held_at',
            'content' => 'nullable|string',
            'class_session_type_id' => 'required|exists:class_session_types,id',
            'zoom_url' => 'nullable|url',
        ]);
    }

    private function createSession(array $data, Classroom $classroom, int $instructorId, string $tz): ClassSession
    {
        return ClassSession::create([
            'classroom_id' => $classroom->id,
            'instructor_id' => $instructorId,
            'held_at' => $this->toUtc($data['held_at'], $tz),
            'end_at' => $this->toUtc($data['end_at'], $tz),
            'content' => $data['content'] ?? null,
            'class_session_type_id' => $data['class_session_type_id'],
            // "Given" is tracked per student (class_session_student), so a new
            // session starts not-given; the instructor marks each student on the
            // attendance page.
            'is_given' => false,
            'zoom_url' => $data['zoom_url'] ?? null,
        ]);
    }

    /* ----------------------------------------------------------------------
     | Calendar invites (ICS email to parents)
     * -------------------------------------------------------------------- */

    /**
     * Queue an ICS calendar invite to each enrolled student's parent.
     * Failures are logged but never block session creation.
     */
    private function sendInvites(Classroom $classroom, ClassSession $session, array $studentUserIds, int $instructorId): void
    {
        try {
            $instructor = User::find($instructorId);
            $instructorEmail = $instructor->email ?? null;
            $parentUserIds = $this->parentUserIdsFor($studentUserIds);

            Log::info('[ICS] Prepared parent recipients', [
                'session_id' => $session->id,
                'parent_count' => count($parentUserIds),
                'instructor_email_present' => (bool) $instructorEmail,
            ]);

            if (empty($parentUserIds) || !$instructorEmail) {
                Log::warning('[ICS] No recipients or missing instructor email', [
                    'session_id' => $session->id,
                    'parent_count' => count($parentUserIds),
                    'instructor_email_present' => (bool) $instructorEmail,
                ]);
                return;
            }

            $meta = $this->buildInviteMeta($classroom, $session, $instructorEmail, $this->fullName($instructor));

            // Only send once the surrounding transaction has committed.
            DB::afterCommit(function () use ($parentUserIds, $session, $meta) {
                foreach ($parentUserIds as $parentUserId) {
                    $this->queueInviteForParent($parentUserId, $session, $meta);
                }
            });
        } catch (\Throwable $e) {
            // Swallow mail errors so they never block session creation.
            Log::error('[ICS] Mail block failed', [
                'session_id' => $session->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Static invite details shared by every recipient of this session.
     */
    private function buildInviteMeta(Classroom $classroom, ClassSession $session, string $instructorEmail, string $instructorName): array
    {
        $domain = parse_url(config('app.url'), PHP_URL_HOST) ?: 'levels-academy.local';
        $tz = config('app.timezone', 'UTC');

        return [
            'uid' => 'session-'.$session->id.'@'.$domain,
            'summary' => 'Class Session at '.$classroom->name,
            'description' => 'Classroom: '.$classroom->name."\n".(string) ($session->content ?? ''),
            'organizer_email' => $instructorEmail,
            'organizer_name' => $instructorName ?: null,
            'start_utc' => Carbon::parse($session->held_at, $tz)->setTimezone('UTC'),
            'end_utc' => Carbon::parse($session->end_at, $tz)->setTimezone('UTC'),
            'classroom_name' => $classroom->name,
        ];
    }

    /**
     * Build the ICS payload + email body and dispatch the invite job for one parent.
     */
    private function queueInviteForParent($parentUserId, ClassSession $session, array $meta): void
    {
        $parentUser = User::find($parentUserId);
        if (!$parentUser || empty($parentUser->email)) {
            return;
        }

        Log::info('[ICS] Queue invite', [
            'session_id' => $session->id,
            'to' => $parentUser->email,
        ]);

        $ics = IcsBuilder::buildInvite([
            'uid' => $meta['uid'],
            'summary' => $meta['summary'],
            'description' => $meta['description'],
            'organizer_email' => $meta['organizer_email'],
            'organizer_name' => $meta['organizer_name'],
            'start_utc' => $meta['start_utc'],
            'end_utc' => $meta['end_utc'],
            'attendees' => [[
                'email' => $parentUser->email,
                'name' => $this->fullName($parentUser),
            ]],
            'sequence' => 0,
            'method' => 'REQUEST',
        ]);

        SendSessionInvite::dispatch(
            $parentUser->email,
            'Class Session Invitation',
            $this->buildInviteEmailBody($meta, $parentUser->timezone),
            $ics
        )->onQueue('default');
    }

    /**
     * HTML body for the invite email. When the recipient's timezone is known it
     * renders the times in their local zone; otherwise falls back to UTC + a
     * "view in local time" link.
     */
    private function buildInviteEmailBody(array $meta, ?string $tz = null): string
    {
        /** @var Carbon $startUtc */
        $startUtc = $meta['start_utc'];
        /** @var Carbon $endUtc */
        $endUtc = $meta['end_utc'];

        $useTz = ($tz && in_array($tz, timezone_identifiers_list(), true)) ? $tz : null;

        if ($useTz) {
            $startText = $startUtc->copy()->setTimezone($useTz)->format('Y-m-d H:i').' ('.$useTz.')';
            $endText = $endUtc->copy()->setTimezone($useTz)->format('Y-m-d H:i').' ('.$useTz.')';
        } else {
            $startText = $startUtc->format('Y-m-d H:i').' UTC';
            $endText = $endUtc->format('Y-m-d H:i').' UTC';
        }

        $startLocalLink = 'https://www.timeanddate.com/worldclock/fixedtime.html?iso='.$startUtc->format('Ymd\THis\Z');
        $endLocalLink = 'https://www.timeanddate.com/worldclock/fixedtime.html?iso='.$endUtc->format('Ymd\THis\Z');

        return '<p>You have a new class session.</p>'
            .'<p><strong>'.$meta['summary'].'</strong></p>'
            .'<p>Classroom: '.$meta['classroom_name'].'</p>'
            .'<p>'
            .'Starts: '.$startText.' '
            .'(<a href="'.$startLocalLink.'">view in your local time</a>)'
            .'<br>'
            .'Ends: '.$endText.' '
            .'(<a href="'.$endLocalLink.'">view in your local time</a>)'
            .'</p>'
            .'<p>Tip: Open the attached calendar invite; your calendar will show the event in your local time automatically.</p>';
    }

    /**
     * Unique parent user IDs for the given enrolled students.
     */
    private function parentUserIdsFor(array $studentUserIds): array
    {
        $parentUserIds = [];
        foreach ($studentUserIds as $studentUserId) {
            $student = Student::find($studentUserId);
            if (!$student) {
                continue;
            }
            $parent = $student->parentts()->first();
            if ($parent && $parent->user_id) {
                $parentUserIds[$parent->user_id] = true;
            }
        }

        return array_keys($parentUserIds);
    }

    /* ----------------------------------------------------------------------
     | Small shared helpers
     * -------------------------------------------------------------------- */

    /**
     * 403 unless the current instructor owns the session.
     */
    private function authorizeOwnership(ClassSession $session): void
    {
        if ((int) $session->instructor_id !== (int) Auth::id()) {
            abort(403);
        }
    }

    /**
     * 403 unless the current instructor owns the classroom.
     */
    private function authorizeClassroomOwnership(Classroom $classroom, int $instructorId): void
    {
        if ((int) $classroom->instructor_id !== $instructorId) {
            abort(403);
        }
    }

    /**
     * Validated browser timezone, falling back to the app timezone.
     */
    private function resolveTimezone(Request $request): string
    {
        $tz = (string) $request->input('tz', config('app.timezone', 'UTC'));

        return in_array($tz, timezone_identifiers_list(), true)
            ? $tz
            : config('app.timezone', 'UTC');
    }

    /**
     * Parse a local datetime string in $tz and convert it to UTC.
     */
    private function toUtc(string $value, string $tz): Carbon
    {
        return Carbon::parse($value, $tz)->timezone('UTC');
    }

    /**
     * "First Last" trimmed; empty string when the user is missing.
     */
    private function fullName(?User $user): string
    {
        if (!$user) {
            return '';
        }

        return trim(($user->first_name ?? '').' '.($user->last_name ?? ''));
    }
}
