<?php

namespace DataSource\Entities\Transaction;

use DataSource\Entities\Course\Course;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'course_id',
        'student_id',
        'price',
        'type',
        'is_credit',
        'desc',
    ];

    public function parent()
    {
        return $this->belongsTo(Parentt::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }
}
