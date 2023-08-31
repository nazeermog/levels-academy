<?php

namespace DataSource\Entities\Course;

use DataSource\Entities\User\User;
use DataSource\Entities\Course\Course;
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
