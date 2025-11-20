<?php

namespace DataSource\Entities\Classroom;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\User\User;
use DataSource\Entities\Classroom\ClassSessionType;

class Classroom extends Model
{
    protected $fillable = [
        'name',
        'repeats_per_week',
        'organization_id',
        'instructor_id',
        'class_session_type_id',
        'days_of_week',
        'session_time',
    ];

    public function scopeInOrganization($query, int $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function students()
    {
        // student_id references users.id
        return $this->belongsToMany(User::class, 'classroom_student', 'classroom_id', 'student_id');
    }

    public function sessions()
    {
        return $this->hasMany(ClassSession::class);
    }

    public function defaultSessionType()
    {
        return $this->belongsTo(ClassSessionType::class, 'class_session_type_id');
    }
}


