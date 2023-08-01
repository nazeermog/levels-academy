<?php

namespace DataSource\Entities\Course;

use Illuminate\Database\Eloquent\Model;

class CourseContentTranslation extends Model
{
    protected $fillable = [
        'title',
        'desc'
    ];

}
