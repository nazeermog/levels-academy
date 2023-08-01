<?php

namespace DataSource\Entities\Course;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\Course\CourseContent;

class CourseStep extends Model
{
    use  Translatable;

    protected $table = 'course_steps';

    public $translationForeignKey = 'course_step_id';
    protected $translatedAttributes = [
        'title',
        'desc',
    ];

    protected $fillable = [
        'stepable_type',
        'stepable_id',   
        'ordering',
        'is_active',
        'course_content_id',
   
    ];
    public function courseContent()
    {
        return $this->belongsToMany(CourseContent::class);
    }

}
