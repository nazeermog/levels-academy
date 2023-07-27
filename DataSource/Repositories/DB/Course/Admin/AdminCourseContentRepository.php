<?php

namespace DataSource\Repositories\DB\Course\Admin;

use DataSource\Entities\Course\Course;
use DataSource\Entities\Course\CourseContent;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminCourseContentRepository
{
    use AdminCRUDGenericRepository;

    protected $model = CourseContent::class;
    protected $typeModel = Course::class;

    public function store($data)
    {
        //$stepsArray = (($data->get('data')));
// $courseData = json_decode($data['boxArr'], true);
        $course = $this->getTypeModel();
        foreach (localeSupported() as $locale) {
            $course->translateOrNew($locale)->title = $data['title-' . $locale];
            $course->translateOrNew($locale)->slug = $data['slug-' . $locale];
        }
        $course->price = $data['price'];
        $course->taxonomy_id = 1;
        $course->is_auto_join = 1;
        $course->save();
      
        foreach ($data['boxArr'] as $item) {
            $content = $this->getModel();
            $content->ordering = $item['ordering'];
            $content->course_id = $course->id;

            foreach ($item['type'] as $typeItem) {
                $content->content_type = $typeItem['type'];
                $content->content_id = $typeItem['id'];
                $content->save();
            }
        }
        return $course;
    }
}
