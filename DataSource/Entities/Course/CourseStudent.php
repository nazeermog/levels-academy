<?php

namespace DataSource\Entities\Course;

use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use DataSource\Entities\PracticeType\PracticeType;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Worksheet\Worksheet;
use DataSource\Entities\Link\Link;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseStudent extends Model
{
    protected $table = 'course_students';

    protected $fillable = [
        'student_id',
        'course_id',
        'lesson_id',
        'practice_id',
        'worksheet_id',
        'link_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class, 'worksheet_id');
    }
    public function link()
    {
        return $this->belongsTo(Link::class, 'link_id');
    }
    public function practice()
    {
        return $this->belongsTo(PracticeType::class, 'practice_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
