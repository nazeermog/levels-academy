<?php

namespace DataSource\Entities\Classroom;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\User\User;
use DataSource\Entities\Student\Student;

/**
 * A single student's participation in a class session: given / not, the note of
 * what they learned, and whether the parent has already been charged for it.
 */
class ClassSessionStudent extends Model
{
    protected $table = 'class_session_student';

    protected $fillable = [
        'class_session_id',
        'student_id',
        'is_given',
        'notes',
        'given_at',
        'charged',
        'transaction_id',
    ];

    protected $casts = [
        'is_given' => 'boolean',
        'charged' => 'boolean',
        'given_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(ClassSession::class, 'class_session_id');
    }

    /** The student profile (students.user_id). */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    /** The underlying user row (users.id). */
    public function studentUser()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
