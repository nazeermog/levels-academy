<?php

namespace DataSource\Entities\Course;

use DataSource\Entities\Lesson\Lesson;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\Course\CourseContent;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Worksheet\Worksheet;
use DataSource\Entities\Link\Link;
use DataSource\Entities\PracticeType\PracticeType;
use DataSource\Entities\PracticeType\PracticeTypeDetail;

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
    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'stepable_id','id');
    }
    public function practiceType()
    {
        return $this->belongsTo(PracticeType::class);
    }
    public function practiceTypeDetail()
    {
        return $this->belongsTo(PracticeTypeDetail::class,'stepable_id');
    }

    /**
     * The class session this step points to (when stepable_type === 'ClassSessions').
     */
    public function classSession()
    {
        return $this->belongsTo(ClassSession::class, 'stepable_id');
    }

    /**
     * The worksheet this step points to (when stepable_type === 'Worksheets').
     */
    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class, 'stepable_id');
    }

    /**
     * The link this step points to (when stepable_type === 'Links').
     */
    public function link()
    {
        return $this->belongsTo(Link::class, 'stepable_id');
    }



   

}
