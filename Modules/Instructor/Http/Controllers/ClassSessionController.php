<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\ClassSessionType;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Transaction\Transaction;
use DataSource\Entities\User\User;
use Illuminate\Support\Facades\DB;
use App\Support\IcsBuilder;
use App\Mail\SessionInvite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendSessionInvite;

class ClassSessionController extends Controller
{
    public function index()
    {
        $instructorId = Auth::id();
        $sessions = ClassSession::normal()
            ->with(['classroom', 'type'])
            ->where('instructor_id', $instructorId)
            ->orderByDesc('held_at')
            ->paginate(20);
        return view('instructor::classrooms.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $instructorId = Auth::id();
        $classrooms = Classroom::where('instructor_id', $instructorId)->orderBy('name')->get();
        $orgId = optional($classrooms->first())->organization_id;
        $types = $orgId ? ClassSessionType::inOrganization($orgId)->orderBy('name')->get() : collect();
        return view('instructor::classrooms.sessions.create', compact('classrooms', 'types'));
    }

    public function edit(ClassSession $session)
    {
        $instructorId = Auth::id();
        if ((int) $session->instructor_id !== (int) $instructorId) {
            abort(403);
        }
        return view('instructor::classrooms.sessions.edit', compact('session'));
    }

    public function update(Request $request, ClassSession $session)
    {
        $instructorId = Auth::id();
        if ((int) $session->instructor_id !== (int) $instructorId) {
            abort(403);
        }
        $data = $request->validate([
            'content' => 'nullable|string',
        ]);
        $session->update([
            'content' => $data['content'] ?? null,
        ]);
        return redirect()->route('instructor.sessions.index')->with('success', 'Session updated.');
    }

    public function store(Request $request)
    {
        $instructorId = Auth::id();
        $data = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'held_at' => 'required|date',
            'end_at' => 'required|date|after:held_at',
            'content' => 'nullable|string',
            'class_session_type_id' => 'required|exists:class_session_types,id',
        ]);
        $classroom = Classroom::findOrFail($data['classroom_id']);
        if ((int) $classroom->instructor_id !== (int) $instructorId) {
            abort(403);
        }

        // Convert provided local times to UTC using browser-detected tz (fallback to app tz)
        $tz = (string) $request->input('tz', config('app.timezone', 'UTC'));
        if (!in_array($tz, timezone_identifiers_list(), true)) {
            $tz = config('app.timezone', 'UTC');
        }
        $heldAtUtc = Carbon::parse($data['held_at'], $tz)->timezone('UTC');
        $endAtUtc  = Carbon::parse($data['end_at'],  $tz)->timezone('UTC');

        DB::beginTransaction();
        try {
            $type = ClassSessionType::findOrFail($data['class_session_type_id']);

            $session = ClassSession::create([
                'classroom_id' => $classroom->id,
                'instructor_id' => $instructorId,
                'held_at' => $heldAtUtc,
                'end_at' => $endAtUtc,
                'content' => $data['content'] ?? null,
                'class_session_type_id' => $data['class_session_type_id'],
            ]);

            $studentUserIds = $classroom->students()->pluck('users.id')->toArray();
            $numStudents = count($studentUserIds);
            if ($numStudents > 0) {
                $perStudentPrice = $type->price; // charge full price per student
                foreach ($studentUserIds as $studentUserId) {
                    $student = Student::find($studentUserId);
                    if (!$student) { continue; }
                    $parent = $student->parentts()->first();
                    if (!$parent) { continue; }
                    Transaction::create([
                        'parent_id' => $parent->user_id,
                        'course_id' => 0,
                        'student_id' => $student->user_id,
                        'price' => $perStudentPrice,
                        'type' => 'once',
                        'is_credit' => 0,
                        'desc' => 'Class session #'.$session->id.' charge: '.$type->name,
                    ]);
                }
            }

            // Send ICS invite to each parent (non-blocking)
            try {
                $instructorUser = User::find($instructorId);
                $instructorEmail = $instructorUser?->email ?? null;
                $instructorName = trim(($instructorUser->first_name ?? '') . ' ' . ($instructorUser->last_name ?? ''));
                $domain = parse_url(config('app.url'), PHP_URL_HOST) ?: 'levels-academy.local';
                $uid = 'session-'.$session->id.'@'.$domain;
                $tz = config('app.timezone', 'UTC');
                $startUtc = Carbon::parse($session->held_at, $tz)->setTimezone('UTC');
                $endUtc = Carbon::parse($session->end_at, $tz)->setTimezone('UTC');
                $summary = 'Class Session at '.$classroom->name;
                $description = 'Classroom: '.$classroom->name."\n".(string) ($session->content ?? '');

                // Gather unique parent users (resolve from student IDs)
                $parentUserIds = [];
                foreach ($studentUserIds as $studentUserId) {
                    $student = Student::find($studentUserId);
                    if (!$student) { continue; }
                    $p = $student->parentts()->first();
                    if ($p && $p->user_id) {
                        $parentUserIds[$p->user_id] = true;
                    }
                }
                $parentUserIds = array_keys($parentUserIds);
                Log::info('[ICS] Prepared parent recipients', [
                    'session_id' => $session->id,
                    'parent_count' => count($parentUserIds),
                    'instructor_email_present' => (bool) $instructorEmail,
                ]);
                if (!empty($parentUserIds) && $instructorEmail) {
                    DB::afterCommit(function () use ($parentUserIds, $session, $summary, $instructorEmail, $instructorName, $uid, $startUtc, $endUtc, $classroom, $description) {
                        foreach ($parentUserIds as $pid) {
                            $parentUser = User::find($pid);
                            if (!$parentUser || empty($parentUser->email)) { continue; }
                            Log::info('[ICS] Queue invite', [
                                'session_id' => $session->id,
                                'to' => $parentUser->email,
                            ]);
                            $attendees = [['email' => $parentUser->email, 'name' => trim(($parentUser->first_name ?? '').' '.($parentUser->last_name ?? ''))]];
                            $ics = IcsBuilder::buildInvite([
                                'uid' => $uid,
                                'summary' => $summary,
                                'description' => $description,
                                'organizer_email' => $instructorEmail,
                                'organizer_name' => $instructorName ?: null,
                                'start_utc' => $startUtc,
                                'end_utc' => $endUtc,
                                'attendees' => $attendees,
                                'sequence' => 0,
                                'method' => 'REQUEST',
                            ]);
                            $startUtcText = $startUtc->format('Y-m-d H:i') . ' UTC';
                            $endUtcText = $endUtc->format('Y-m-d H:i') . ' UTC';
                            $startIsoParam = $startUtc->format('Ymd\THis\Z');
                            $endIsoParam = $endUtc->format('Ymd\THis\Z');
                            $startLocalLink = 'https://www.timeanddate.com/worldclock/fixedtime.html?iso=' . $startIsoParam;
                            $endLocalLink = 'https://www.timeanddate.com/worldclock/fixedtime.html?iso=' . $endIsoParam;

                            $body = '<p>You have a new class session.</p>'
                                . '<p><strong>' . $summary . '</strong></p>'
                                . '<p>Classroom: ' . $classroom->name . '</p>'
                                . '<p>'
                                . 'Starts: ' . $startUtcText . ' '
                                . '(<a href="' . $startLocalLink . '">view in your local time</a>)'
                                . '<br>'
                                . 'Ends: ' . $endUtcText . ' '
                                . '(<a href="' . $endLocalLink . '">view in your local time</a>)'
                                . '</p>'
                                . '<p>Tip: Open the attached calendar invite; your calendar will show the event in your local time automatically.</p>';
                            SendSessionInvite::dispatch(
                                $parentUser->email,
                                'Class Session Invitation',
                                $body,
                                $ics
                            )->onQueue('default');
                        }
                    });
                } else {
                    Log::warning('[ICS] No recipients or missing instructor email', [
                        'session_id' => $session->id,
                        'parent_count' => count($parentUserIds),
                        'instructor_email_present' => (bool) $instructorEmail,
                    ]);
                }
            } catch (\Throwable $e) {
                // swallow mail errors to not block session creation
                Log::error('[ICS] Mail block failed', [
                    'session_id' => $session->id ?? null,
                    'error' => $e->getMessage(),
                ]);
            }

            DB::commit();
            return redirect()->route('instructor.sessions.index')->with('success', 'Session saved. Parent transactions added.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}


