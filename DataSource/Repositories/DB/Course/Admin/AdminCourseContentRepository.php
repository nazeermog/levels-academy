<?php

namespace DataSource\Repositories\DB\Course\Admin;

use Illuminate\Http\Request;
use DataSource\Entities\Course\Course;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Course\CourseStep;
use DataSource\Entities\Course\CourseContent;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminCourseContentRepository
{
    use AdminCRUDGenericRepository;

    protected $typeModel = CourseContent::class;
    protected $model = Course::class;

    public function store(Request $request,$data)
    {
        //$stepsArray = (($data->get('data')));
        // $courseData = json_decode($data['boxArr'], true);
        $course = $this->getModel();
        foreach (localeSupported() as $locale) {
            $course->translateOrNew($locale)->title = $data['title-' . $locale];
            $course->translateOrNew($locale)->slug = $data['slug-' . $locale];
            $course->translateOrNew($locale)->desc = $data['desc-' . $locale];
            $course->translateOrNew($locale)->about = $data['about-' . $locale];
            $course->translateOrNew($locale)->benefit = $data['benefit-' . $locale];
            $course->translateOrNew($locale)->level = $data['level-' . $locale];

        }
        $course->price = $data['price'];
        $course->taxonomy_id = $data['taxonomy_id'];
        $course->instructor_id = $data['instructor_id'];;
        $course->is_auto_join = 1;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/course_photos');
            $course->photo = Storage::url($photoPath);
        }

        $course->save();

        foreach ($data['boxArr'] as $item) {
            $content = $this->getTypeModel();
            foreach (localeSupported() as $locale) {
                $content->translateOrNew($locale)->title = $item['title'];
                $content->translateOrNew($locale)->desc = $item['desc'];

            }
            $content->ordering = $item['ordering'];
            $content->course_id = $course->id;
            $content->save();

            //todo::add steps
            foreach($item['type'] as $typeItem) {
                $step = new CourseStep();
                $step->stepable_type = $typeItem['type'];
                $step->stepable_id = $typeItem['id'];
           foreach(localeSupported() as $locale) {
                $step->translateOrNew($locale)->title = $typeItem['title'];
            }
            $step->ordering = $typeItem['ordering'];
            $step->course_content_id=$content->id;
            $step->save();
        }}
        return $course;
    }
    public function update(Request $request,$data,$courseId)
    {
        $course = Course::find($courseId);
        foreach (localeSupported() as $locale) {
            $course->translateOrNew($locale)->title = $data['title-' . $locale];
            $course->translateOrNew($locale)->slug = $data['slug-' . $locale];
            $course->translateOrNew($locale)->desc = $data['desc-' . $locale];
            $course->translateOrNew($locale)->about = $data['about-' . $locale];
            $course->translateOrNew($locale)->benefit = $data['benefit-' . $locale];
            $course->translateOrNew($locale)->level = $data['level-' . $locale];

        }
        $course->price = $data['price'];
        $course->taxonomy_id = $data['taxonomy_id'];
        $course->instructor_id = $data['instructor_id'];;
        $course->is_auto_join = 1;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/course_photos');
            $course->photo = Storage::url($photoPath);
        }

        $course->save();
         //dd($data);
        foreach ($data['boxArr'] as $index => $item) {
            $content = isset($course->courseContents[$index]) ? $course->courseContents[$index] : new CourseContent();
        
            if ($content) {
                $content->ordering = $item['ordering'];
                $content->title = $item['title'];
                $content->desc = 
                $content->course_id = $course->id;

                foreach (localeSupported() as $locale) {
                    $content->translateOrNew($locale)->title = $item['title'];
                    $content->translateOrNew($locale)->desc =$item['desc'];
                }
                $content->save();

                $content->courseSteps()->delete();

                foreach ($item['type'] as $typeItem) {
                    $step = CourseStep::find($typeItem['id']); // Assuming you have a step ID
        
                    if (!$step) {
                        $step = new CourseStep();
                    }
                        $step->stepable_type = $typeItem['type'];
                        $step->stepable_id = $typeItem['id'];
                        
                        foreach (localeSupported() as $locale) {
                            $step->translateOrNew($locale)->title = $typeItem['title'];
                        }
                        $step->ordering = $typeItem['ordering'];
                        $step->course_content_id = $content->id;
                        $step->save();
                }
                        }}
        return $course;
    }

    
}
