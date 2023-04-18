<?php

namespace DataSource\Repositories\DB\Lesson\Admin;

use DataSource\Entities\Lesson\Lesson;

class AdminLessonRepository
{
    public static function list()
    {
        return Lesson::all();
    }
}
