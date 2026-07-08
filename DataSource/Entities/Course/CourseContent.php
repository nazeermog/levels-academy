<?php

namespace DataSource\Entities\Course;

use DataSource\Entities\Course\Course;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\Course\CourseStep;

/**
 * @property int $id
 * @property string $title
 * @property int $course_id
 * @property int $ordering
 * @property string $content_type
 * @property int $content_id
 */
class CourseContent extends Model
{
    use Translatable;

    protected $table = 'course_contents';

    public $translationForeignKey = 'course_content_id';
    protected $translatedAttributes = [
        'title',
        'desc'
    ];

    protected $fillable = [
        'course_id',
        'ordering',
        'step_type',
    ];

    public const TYPE_NORMAL = 'normal';
    public const TYPE_CLASSROOM = 'classroom';

    public function isClassroom(): bool
    {
        return $this->step_type === self::TYPE_CLASSROOM;
    }

    public function courseSteps()
    {
        return $this->hasMany(CourseStep::class);
    }
    public function course()
    {
        return $this->belongsto(Course::class);
    }
  
}
