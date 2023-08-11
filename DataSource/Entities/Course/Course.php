<?php

namespace DataSource\Entities\Course;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\Course\CoursePath;
use DataSource\Entities\Course\CourseContent;
use DataSource\Entities\Instructor\Instructor;


class Course extends Model
{
    use Translatable;

    protected $table = 'courses';
    public $translationForeignKey = 'course_id';
    protected $translatedAttributes = [
        'title',
        'slug',
        'desc',
        'about',
        'benefit',
        'level',
    ];
    protected $fillable = [
        'price',
        'taxonomy_id',
        'instructor_id',
        'is_auto_join',
        'course_path_id',
        'is_active',
        'photo',
    ];
    public function courseContents()
    {
        return $this->hasMany(CourseContent::class);
    }
    public function CoursePath()
    {
        return $this->belongsTo(CoursePath::class);
    }
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
