<?php

namespace Modules\DataResource\Entities\Course;

use Illuminate\Database\Eloquent\Model;

class CourseTranslation extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'desc'
    ];
}
