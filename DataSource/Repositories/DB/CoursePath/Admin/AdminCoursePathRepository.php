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
        return CoursePath::all();

    }
    public static function find($pathId)
    {
        return CoursePath::find($pathId);

    }
    public static function CourseCounter()
    {
        $coursePaths = CoursePath::all();
        $totalLessons=0;
        // Calculate the total number of courses for each course path
        $courseLessons = [];
    foreach ($coursePaths as $coursePath) {
        $totalLessons = 0;
            $totalLessons += $coursePath->courses()->count();
        $courseLessons[$coursePath->id] = $totalLessons;
    }
        return $courseLessons;
    }
    
    public function store( $request, $data)
    {
        $ordering=1;
            $coursePath = $this->getModel();
            foreach (localeSupported() as $locale) {
                $coursePath->translateOrNew($locale)->title = $data['title-' . $locale];
                $coursePath->translateOrNew($locale)->desc = $data['desc-' . $locale];
                $coursePath->translateOrNew($locale)->about = $data['about-' . $locale];
                $coursePath->translateOrNew($locale)->benefit = $data['benefit-' . $locale];

            }
            $coursePath->taxonomy_id = $data['taxonomy_id'];
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('public/course_path_photos');
                $coursePath->photo = Storage::url($photoPath);
            }
            $coursePath->save();
            foreach ($data['course_id'] as $courseId) {
            $course=Course::find($courseId);
            $course->course_path_id=$coursePath->id;  
            $course->ordering = $ordering;
            $course->save(); 
            $ordering++;
        }
    }

}
