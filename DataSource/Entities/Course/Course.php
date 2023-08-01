<?php

namespace DataSource\Entities\Course;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\Course\CourseContent;


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
        'photo',
    ];
    public function courseContents()
    {
        return $this->hasMany(CourseContent::class);
    }
}
