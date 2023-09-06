<?php

namespace DataSource\Entities\Course;

use DataSource\Entities\Course\Rating;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Student\Student;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\Course\CoursePath;
use DataSource\Entities\Semester\Semester;
use DataSource\Entities\Course\CourseContent;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Entities\Taxonomy\Taxonomy;

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
        'ordering',
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
    public function ratings(){

        return $this->hasMany(Rating::class);
    }
    public function inrollments()
    {
        return $this->hasMany(Inrollment::class, 'course_id');
    }
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_students');
    }
    public function semester()
    {
        return $this->belongsToMany(Semester::class);
    }
    
}
