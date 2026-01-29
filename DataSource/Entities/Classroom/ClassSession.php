<?php

namespace DataSource\Entities\Classroom;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\User\User;

class ClassSession extends Model
{
    protected $fillable = [
        'classroom_id',
        'instructor_id',
        'held_at',
        'end_at',
        'content',
        'class_session_type_id',
    ];

    protected $casts = [
        'held_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function type()
    {
        return $this->belongsTo(ClassSessionType::class, 'class_session_type_id');
    }
}


