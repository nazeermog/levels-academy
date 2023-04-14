<?php

namespace DataSource\Repositories\DB\Course\Admin;

use Modules\DataResource\Entities\Course\CourseContent;
use Modules\DataResource\Traits\Admin\AdminCRUDGenericRepository;

class AdminCourseContentRepository
{
    use AdminCRUDGenericRepository;

    protected $model = CourseContent::class;
    public function store($data)
    {
//        $content = new CourseContent();
        $content = $this->getModel();
        $content->course_id = $data['course_id'];
        $content->content_type = get_class($data['course_type']);
        $content->content_id = $data['course_id'];
        $content->save();
        return $content;
    }
}
