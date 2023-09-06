<?php

namespace Modules\Lesson\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use DataSource\Entities\Course\CourseStep;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Entities\Course\CourseContent;
use DataSource\Entities\Course\CourseStudent;
use DataSource\Entities\Inrollment\Inrollment;
use Modules\Inrollment\Http\Controllers\InrollmentController;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\CoursePath\Admin\AdminCoursePathRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;
use DataSource\Repositories\DB\Course\Student\StudentCourseRatingRepository;

class LessonController extends Controller
{
    public function show($lessonId, $courseId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        $course = Course::findOrFail($courseId);

        $totalLessonTime = AdminLessonRepository::SingleCoursTotalLesson($course);
        $instructor = AdminInstructorRepository::InstructorForOneCourse($course);
        $courseRate = StudentCourseRatingRepository::CalculateAverageRatingForCourse($course);
        $ratingCount = StudentCourseRatingRepository::RatingCount($course);
        $watched = InrollmentController::isWatched($courseId, $lessonId);
        return view('lesson::student.show', [
            'lesson' => $lesson,
            'course' => $course,
            'totalLessonTime' => $totalLessonTime,
            'instructor' => $instructor,
            'courseRate' => $courseRate,
            'ratingCount' => $ratingCount,
            'watched' => $watched,
        ]);
    }
    public function watched($lessonId, $courseId)
    {
        $studentId = auth()->user()->id;

        $inrollment = Inrollment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->first();

        if (!$inrollment) {
            return redirect()->back()->withErrors('you should be enroll to this course');
        }
        $existingRecord = CourseStudent::where('student_id', $studentId)
            ->where('lesson_id', $lessonId)
            ->where('course_id', $courseId)
            ->first();

        if (!$existingRecord) {
            CourseStudent::create([
                'student_id' => $studentId,
                'lesson_id' => $lessonId,
                'course_id' => $courseId,
            ]);
        }
        $totalWatchedTime = CourseStudent::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->join('lessons', 'course_students.lesson_id', '=', 'lessons.id')
            ->sum('lessons.time');

        $course = Course::find($courseId);
        $totalLessonTimeOld = AdminLessonRepository::SingleCoursTotalLesson($course);

        $progressPercentage = ($totalWatchedTime / $totalLessonTimeOld) * 100;
        if ($inrollment) {
            $inrollment->progress_lesson = number_format($progressPercentage, 1);
            $inrollment->update();
        }
        return redirect()->back()->withSuccess('Lesson marked as watched');
    }


    public static function  isWatched($courseId, $lessonId)
    {
        $studentId = auth()->user()->id;

        $watched = CourseStudent::where('student_id', $studentId)
            ->where('lesson_id', $lessonId)
            ->where('course_id', $courseId)
            ->first();
        return $watched;
    }
}
