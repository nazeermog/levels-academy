<?php

namespace DataSource\Entities\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonTranslation extends Model
{
    protected $fillable = [
        'title',
        'desc'
    ];

}
