<?php

namespace DataSource\Entities\Instructor;

use DataSource\Entities\User\User;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstructorNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'student_id',
        'note',
        'is_read'
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
}
