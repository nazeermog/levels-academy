<?php

namespace DataSource\Entities\Course;

use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use DataSource\Entities\PracticeType\PracticeType;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseStudent extends Model
{
    protected $table = 'course_students';

    protected $fillable = [
        'student_id',
        'course_id',
        'lesson_id',
        'practice_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
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
