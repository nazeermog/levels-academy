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

    protected $model = CourseContent::class;
    protected $typeModel = Course::class;

    public function store(Request $request,$data)
    {
        //$stepsArray = (($data->get('data')));
        // $courseData = json_decode($data['boxArr'], true);
        $course = $this->getTypeModel();
        foreach (localeSupported() as $locale) {
            $course->translateOrNew($locale)->title = $data['title-' . $locale];
            $course->translateOrNew($locale)->slug = $data['slug-' . $locale];
        }
        $course->price = $data['price'];
        $course->taxonomy_id = $data['taxonomy_id'];
        $course->is_auto_join = 1;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/course_photos');
            $course->photo = Storage::url($photoPath);
        }

        $course->save();

        foreach ($data['boxArr'] as $item) {
            $content = $this->getModel();
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
                $step->translateOrNew($locale)->title = $item['title'];
                $step->translateOrNew($locale)->desc = $item['desc'];
            }
            $step->ordering = $item['ordering'];
            $step->course_content_id=$content->id;
            $step->save();
        }}
        return $course;
    }

    
}
