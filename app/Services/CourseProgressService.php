<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Course\CourseContent;
use DataSource\Entities\Course\CourseStudent;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\ClassSessionStudent;

/**
 * Computes per-student course progress from the completion signals that already
 * exist in the system, so every role (student, instructor, parent, admin) sees
 * the same picture without a separate progress table that could drift:
 *
 *  - Lesson step       (stepable_type "Lessons")       => a course_students row with this lesson_id
 *                       (written when the student marks the lesson watched).
 *  - Practice step     (stepable_type "Practices")     => a course_students row with this practice_id
 *                       (written when the student completes the practice).
 *  - ClassSession step (stepable_type "ClassSessions") => a class_session_student row for THIS
 *                       student with is_given=true (per-student attendance) — applicable only to
 *                       students who belong to that session's classroom. It is NOT the session-wide
 *                       class_sessions.is_given flag, so a newly-enrolled student never inherits a
 *                       session they didn't personally attend.
 *
 * Quizzes / other step types are not counted (no completion signal yet).
 */
class CourseProgressService
{
    /** Step types that contribute to progress. */
    private const COUNTED_TYPES = ['Lessons', 'Practices', 'ClassSessions'];

    /**
     * Per-student progress reports for one course, batched to avoid N+1.
     *
     * @param  int[]  $studentIds  student user ids (students.user_id)
     * @return array<int,array>    keyed by student id; see buildReport() for shape
     */
    public function reports(Course $course, array $studentIds): array
    {
        $studentIds = array_values(array_unique(array_map('intval', $studentIds)));
        if (empty($studentIds)) {
            return [];
        }

        $contents = $this->contents($course);

        // Which stepable ids do we need completion signals for?
        $sessionIds = [];
        foreach ($contents as $content) {
            foreach ($content->courseSteps as $step) {
                if ($step->stepable_type === 'ClassSessions') {
                    $sessionIds[] = (int) $step->stepable_id;
                }
            }
        }

        // --- Lesson / practice completions (one query) ------------------------
        $doneLesson = [];   // [studentId][lessonId] = true
        $donePractice = []; // [studentId][practiceId] = true
        $rows = CourseStudent::where('course_id', $course->id)
            ->whereIn('student_id', $studentIds)
            ->get(['student_id', 'lesson_id', 'practice_id']);
        foreach ($rows as $row) {
            if ($row->lesson_id) {
                $doneLesson[(int) $row->student_id][(int) $row->lesson_id] = true;
            }
            if ($row->practice_id) {
                $donePractice[(int) $row->student_id][(int) $row->practice_id] = true;
            }
        }

        // --- Class session: which classroom each belongs to (applicability),
        //     student classroom membership, and PER-STUDENT given attendance ----
        $sessionClassroom = []; // [sessionId] = classroomId
        $studentClassrooms = []; // [studentId][classroomId] = true
        $givenByStudent = []; // [studentId][sessionId] = true — this student's own attendance
        if (!empty($sessionIds)) {
            foreach (ClassSession::whereIn('id', $sessionIds)->get(['id', 'classroom_id']) as $s) {
                $sessionClassroom[(int) $s->id] = (int) $s->classroom_id;
            }
            foreach (DB::table('classroom_student')->whereIn('student_id', $studentIds)->get(['student_id', 'classroom_id']) as $m) {
                $studentClassrooms[(int) $m->student_id][(int) $m->classroom_id] = true;
            }
            foreach (ClassSessionStudent::whereIn('class_session_id', $sessionIds)
                ->whereIn('student_id', $studentIds)
                ->where('is_given', true)
                ->get(['student_id', 'class_session_id']) as $a) {
                $givenByStudent[(int) $a->student_id][(int) $a->class_session_id] = true;
            }
        }

        $reports = [];
        foreach ($studentIds as $sid) {
            $reports[$sid] = $this->buildReport(
                $contents,
                $doneLesson[$sid] ?? [],
                $donePractice[$sid] ?? [],
                $givenByStudent[$sid] ?? [],
                $sessionClassroom,
                $studentClassrooms[$sid] ?? []
            );
        }

        return $reports;
    }

    /**
     * Progress report for a single student.
     */
    public function report(Course $course, int $studentId): array
    {
        return $this->reports($course, [$studentId])[$studentId]
            ?? ['completed' => 0, 'total' => 0, 'percent' => 0, 'contents' => [], 'next_step' => null, 'last_done' => null];
    }

    private function contents(Course $course)
    {
        return CourseContent::where('course_id', $course->id)
            ->with(['translations', 'courseSteps' => function ($q) {
                $q->orderBy('ordering')->with('translations');
            }])
            ->orderBy('ordering')
            ->get();
    }

    /**
     * @return array{completed:int,total:int,percent:int,contents:array,next_step:?array,last_done:?array}
     */
    private function buildReport($contents, array $doneLesson, array $donePractice, array $givenSessions, array $sessionClassroom, array $studentClassrooms): array
    {
        $contentsOut = [];
        $grandTotal = 0;
        $grandDone = 0;
        $nextStep = null;   // first not-completed step in order = where the student is now
        $lastDone = null;   // furthest completed step in order = what they've finished
        $currentMarked = false;

        foreach ($contents as $content) {
            $contentTitle = $content->title;
            $steps = [];
            $cDone = 0;

            foreach ($content->courseSteps as $step) {
                $type = $step->stepable_type;
                if (!in_array($type, self::COUNTED_TYPES, true)) {
                    continue;
                }

                $stepableId = (int) $step->stepable_id;
                $done = false;

                if ($type === 'Lessons') {
                    $done = isset($doneLesson[$stepableId]);
                } elseif ($type === 'Practices') {
                    $done = isset($donePractice[$stepableId]);
                } else { // ClassSessions
                    $classroomId = $sessionClassroom[$stepableId] ?? null;
                    // A session step only applies to students in that session's classroom.
                    if ($classroomId === null || !isset($studentClassrooms[$classroomId])) {
                        continue;
                    }
                    // Done only if THIS student was personally marked given (not the
                    // session-wide flag), so a new enrolee doesn't inherit past sessions.
                    $done = isset($givenSessions[$stepableId]);
                }

                // First not-done step (in path order) is the student's current position.
                $isCurrent = !$done && !$currentMarked;
                if ($isCurrent) {
                    $currentMarked = true;
                    $nextStep = ['title' => $step->title, 'type' => $type, 'content_title' => $contentTitle];
                }
                if ($done) {
                    $lastDone = ['title' => $step->title, 'type' => $type, 'content_title' => $contentTitle];
                }

                $steps[] = [
                    'title' => $step->title,
                    'type' => $type,
                    'done' => $done,
                    'current' => $isCurrent,
                ];
                if ($done) {
                    $cDone++;
                }
            }

            $cTotal = count($steps);
            if ($cTotal === 0) {
                continue; // skip content boxes with no counted steps for this student
            }

            $contentsOut[] = [
                'title' => $contentTitle,
                'steps' => $steps,
                'completed' => $cDone,
                'total' => $cTotal,
            ];
            $grandTotal += $cTotal;
            $grandDone += $cDone;
        }

        return [
            'completed' => $grandDone,
            'total' => $grandTotal,
            'percent' => $grandTotal > 0 ? (int) round($grandDone / $grandTotal * 100) : 0,
            'contents' => $contentsOut,
            'next_step' => $nextStep,
            'last_done' => $lastDone,
        ];
    }
}
