<?php

namespace DataSource\Entities\Parentt;

use DataSource\Entities\User\User;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parentt extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'parentt_student', 'parentt_id', 'student_id');
    }
}
