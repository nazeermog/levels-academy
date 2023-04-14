<?php

namespace DataSource\Entities\Course;

use Illuminate\Database\Eloquent\Model;

class CourseTranslation extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'desc'
    ];
}
