<?php

namespace DataSource\Repositories\DB\CoursePath\Admin;

use DataSource\Entities\Course\Course;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Course\CoursePath;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminCoursePathRepository
{
    use AdminCRUDGenericRepository;

    protected $model = CoursePath::class;

    public static function list()
    {
        // Eager-load courses to avoid an N+1 when callers loop $coursePath->courses.
        return CoursePath::with('courses')->get();
    }
    public static function find($pathId)
    {
        return CoursePath::find($pathId);
    }
    public static function CourseCounter()
    {
        // withCount avoids one COUNT query per course path (N+1).
        $courseLessons = [];
        foreach (CoursePath::withCount('courses')->get() as $coursePath) {
            $courseLessons[$coursePath->id] = $coursePath->courses_count;
        }
        return $courseLessons;
    }

    public static function SinglePathTotalLesson($coursePath)
    {
        $totalLessonTime = 0;
        $courses = $coursePath->courses;
        foreach ($courses as $course) {
            $courseContents = $course->courseContents()->with('courseSteps.lesson')->get();
            foreach ($courseContents as $courseContent) {
                foreach ($courseContent->courseSteps as $step) {
                    if ($step->stepable_type === 'Lessons' && $step->lesson) {
                        $totalLessonTime += $step->lesson->time;
                    }
                }
            }
        }
        return $totalLessonTime;
    }


    public function store($request, $data)
    {
        $ordering = 1;
        $coursePath = $this->getModel();
        foreach (localeSupported() as $locale) {
            $coursePath->translateOrNew($locale)->title = $data['title-' . $locale];
            $coursePath->translateOrNew($locale)->desc = $data['desc-' . $locale];
            $coursePath->translateOrNew($locale)->about = $data['about-' . $locale];
            $coursePath->translateOrNew($locale)->benefit = $data['benefit-' . $locale];
        }
        $coursePath->taxonomy_id = $data['taxonomy_id'];
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/photos');
            $coursePath->photo = Storage::url($photoPath);
        }
        $coursePath->save();
        foreach ($data['course_id'] as $courseId) {
            $course = Course::find($courseId);
            $course->course_path_id = $coursePath->id;
            $course->ordering = $ordering;
            $course->save();
            $ordering++;
        }
    }
    public function update($request, $data)
    {
        $ordering = 1;
        $coursePath = CoursePath::find($data['model_id']);
        foreach (localeSupported() as $locale) {
            $coursePath->translateOrNew($locale)->title = $data['title-' . $locale];
            $coursePath->translateOrNew($locale)->desc = $data['desc-' . $locale];
            $coursePath->translateOrNew($locale)->about = $data['about-' . $locale];
            $coursePath->translateOrNew($locale)->benefit = $data['benefit-' . $locale];
        }
        $coursePath->taxonomy_id = $data['taxonomy_id'];
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/photos');
            $coursePath->photo = Storage::url($photoPath);
        }
        $coursePath->save();

        $oldCourses = Course::where('course_path_id', $coursePath->id)->get();
        foreach ($oldCourses as $oldCourse) {
            $oldCourse->course_path_id = null;
            $oldCourse->save();
        }

        foreach ($data['course_id'] as $courseId) {
            $course = Course::find($courseId);
            $course->course_path_id = $coursePath->id;
            $course->ordering = $ordering;
            $course->save();
            $ordering++;
        }
    }
}
