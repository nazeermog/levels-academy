<?php

namespace DataSource\Entities\Inrollment;

use DataSource\Entities\Course\Course;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Taxonomy\Taxonomy;


class Inrollment extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'approved_at',
        'progress',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }

}
