<?php

namespace DataSource\Entities\Semester;

use DataSource\Entities\BaseModel;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Student\Student;

class Semester extends BaseModel
{

  protected $table = 'Semesters';
  public $translationForeignKey = 'semester_id';

  public $translatedAttributes = [
    'title',
    'desc',
  ];

  protected $fillable = [
    'start_date',
    'end_date',
    'is_active',

  ];
  public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
