<?php

namespace DataSource\Entities\Course;

use DataSource\Entities\Course\Course;
use DataSource\Entities\Student\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'user_id',
        'rate',
        'user_name',
        'user_review'
    ];
    public function courses(){

        return $this->hasMany(Course::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'user_id');
    }

}
