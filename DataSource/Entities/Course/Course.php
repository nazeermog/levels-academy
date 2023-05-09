<?php

namespace DataSource\Entities\Course;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use Translatable;

    protected $table = 'courses';
    public $translationForeignKey = 'course_id';
    protected $translatedAttributes = [
        'title',
        'slug',
        'desc',
        'about'
    ];
    protected $fillable = [
        'price',
        'taxonomy_id',
        'is_auto_join',
        'is_active',
    ];
}
