<?php

namespace DataSource\Entities\Course;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

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
        'title'
    ];

    protected $fillable = [
        'course_id',
        'ordering',
        'content_type',
        'content_id',
    ];

    public function content()
    {
        return $this->morphTo();
    }
}
