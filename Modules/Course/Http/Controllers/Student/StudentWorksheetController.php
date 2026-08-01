<?php

namespace Modules\Course\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\UserEventLogger;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Course\CourseStudent;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Worksheet\Worksheet;
use DataSource\Entities\Link\Link;

/**
 * Opening a worksheet marks it as read for the student — the same completion
 * signal used by lessons/practices (a course_students row), so it counts toward
 * their course progress (visible to parent / instructor / admin).
 */
class StudentWorksheetController extends Controller
{
    /**
     * Clicking a link marks it complete for the student, then redirects to the URL.
     */
    public function openLink($linkId, $courseId)
    {
        $studentId = (int) Auth::id();
        $link = Link::findOrFail($linkId);

        $enrolled = Inrollment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->exists();

        if (!$enrolled) {
            return redirect()->back()->withErrors('You must be enrolled in this course to open its links.');
        }

        CourseStudent::firstOrCreate([
            'student_id' => $studentId,
            'course_id'  => (int) $courseId,
            'link_id'    => $link->id,
        ]);

        UserEventLogger::log('link opened', 'opened link ' . $link->title, 'link');

        return redirect()->away($link->url);
    }

    public function open($worksheetId, $courseId)
    {
        $studentId = (int) Auth::id();
        $worksheet = Worksheet::findOrFail($worksheetId);

        $enrolled = Inrollment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->exists();

        if (!$enrolled) {
            return redirect()->back()->withErrors('You must be enrolled in this course to open its worksheets.');
        }

        // Record the read once (idempotent).
        CourseStudent::firstOrCreate([
            'student_id'   => $studentId,
            'course_id'    => (int) $courseId,
            'worksheet_id' => $worksheet->id,
        ]);

        UserEventLogger::log('worksheet opened', 'opened worksheet ' . $worksheet->title, 'worksheet');

        $path = $worksheet->absolutePath();
        if (!$path) {
            return redirect()->back()->withErrors('This worksheet file is missing.');
        }

        // Download straight to the student's device with a friendly filename,
        // so they never see the raw /storage/... URL.
        return response()->download($path, $worksheet->downloadName());
    }
}
