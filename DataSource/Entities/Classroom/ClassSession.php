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
        'is_given',
        'zoom_url',
    ];

    protected $casts = [
        'held_at' => 'datetime',
        'end_at' => 'datetime',
        'is_given' => 'boolean',
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

    /**
     * Per-student participation records (given / notes / charged) for this session.
     */
    public function attendances()
    {
        return $this->hasMany(ClassSessionStudent::class, 'class_session_id');
    }

    public function scopeFree($query)
    {
        return $query->where('type', self::TYPE_FREE);
    }

    public function scopeNormal($query)
    {
        return $query->where('type', self::TYPE_NORMAL);
    }

    /**
     * The session's pricing/payout type.
     *
     * NOTE: named sessionType() — NOT type() — because this model has a real
     * `type` column (enum 'normal'/'free'). An Eloquent relation method named
     * type() is shadowed by that column, so $session->type would return the
     * string 'normal' instead of the related ClassSessionType.
     */
    public function sessionType()
    {
        return $this->belongsTo(ClassSessionType::class, 'class_session_type_id');
    }
}


