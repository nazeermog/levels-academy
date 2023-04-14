<?php

namespace DataSource\Entities\Lesson;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use Translatable;

    protected $table = 'lessons';

    public $translationForeignKey = 'lesson_id';
    protected $translatedAttributes = [
        'title',
        'desc'
    ];
    protected $fillable = [
        'url',
        'time',
        'is_active',
    ];

}
