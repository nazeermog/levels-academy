<?php

namespace DataSource\Entities\Classroom;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\User\User;

class ClassSession extends Model
{
    public const TYPE_NORMAL = 'normal';
    public const TYPE_FREE = 'free';

    protected $fillable = [
        'classroom_id',
        'instructor_id',
        'student_user_id',
        'held_at',
        'end_at',
        'content',
        'class_session_type_id',
        'type',
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

    /**
     * Attendee of a free session (the user who requested it).
     */
    public function attendee()
    {
        return $this->belongsTo(User::class, 'student_user_id');
    }

    public function scopeFree($query)
    {
        return $query->where('type', self::TYPE_FREE);
    }

    public function scopeNormal($query)
    {
        return $query->where('type', self::TYPE_NORMAL);
    }

    public function type()
    {
        return $this->belongsTo(ClassSessionType::class, 'class_session_type_id');
    }
}


