<?php

namespace DataSource\Repositories\DB\Course\Admin;

use DataSource\Entities\Course\Course;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminCourseRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Course::class;

}
