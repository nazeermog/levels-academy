<?php

namespace DataSource\Entities\StudentScore;

use DataSource\Entities\Course\Course;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Semester\Semester;
use DataSource\Entities\PracticeType\PracticeTypeDetail;
use Illuminate\Database\Eloquent\Model;

class StudentScore extends Model
{
  protected $table = 'student_scores';
  protected $fillable = [
    'student_id',
    'course_id',
    'practice_id',
    'semester_id',
    'coin'
  ];
  public function student()
{
    return $this->belongsTo(Student::class,'student_id', 'user_id');
}
public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}
public function practiceTypeDetail()
{
    return $this->belongsTo(PracticeTypeDetail::class, 'practice_id');
}
public function semester()
{
    return $this->belongsTo(Semester::class, 'semester_id');
}


}
