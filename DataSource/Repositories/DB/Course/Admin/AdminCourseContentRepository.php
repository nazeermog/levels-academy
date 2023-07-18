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
        $stepsArray = (($data->get('data')));
        $courseData = (json_decode($data->get('formdata'),true));
dd($courseData,$stepsArray);
        $course = $this->getTypeModel();
        foreach (localeSupported() as $locale) {
            $course->translateOrNew($locale)->title = $data['title-' . $locale];
            $course->translateOrNew($locale)->slug = $data['slug-' . $locale];
        }
        $course->price = $data['price'];
        $course->taxonomy_id = $data['taxonomy_id'];
        $course->is_active = 1;
        $course->save();
        foreach ($data['arrayData'] as $item) {
            $content = $this->getModel();
            $content->ordering = $item['ordering'];
            $content->course_id = $course->id;
            $content->content_type = get_class($item['course_type']);
            $content->content_id = $item['type_id'];
            $content->save();
        }

        return $course;
    }
}
