<?php

namespace DataSource\Entities\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStepTranslation extends Model
{
    protected $fillable = [
        'title',
        'desc'
    ];
}
