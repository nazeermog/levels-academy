<?php

namespace DataSource\Entities\Lesson;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\Course\CourseStep;

class Lesson extends Model
{
    use Translatable;

    protected $table = 'lessons';

    public $translationForeignKey = 'lesson_id';
    protected $translatedAttributes = [
        'title',
        'desc',
        'attachment_name',
    ];
    protected $fillable = [
        'url',
        'time',
        'is_active',
        'attachment',
        
    ];
    public function courseStep()
    {
        return $this->belongsTo(CourseStep::class, 'stepable_id');
    }
    
}
