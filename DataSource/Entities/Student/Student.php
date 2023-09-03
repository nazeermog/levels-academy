<?php

namespace DataSource\Entities\Student;

use DataSource\Entities\User\User;
use DataSource\Entities\Course\Course;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Inrollment\Inrollment;

/**
 * @property integer $user_id
 * @property string $country
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Student extends Model
{
    protected $primaryKey = 'user_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function inrollments()
    {
        return $this->hasMany(Inrollment::class,'student_id');
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_students');
    }
}
