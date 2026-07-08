<?php

namespace DataSource\Entities\FreeSession;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\User\User;
use DataSource\Entities\Classroom\ClassSession;

class FreeSessionRequest extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_GIVEN = 'given';

    protected $fillable = [
        'user_id',
        'note',
        'instructor_note',
        'status',
        'instructor_id',
        'availability_id',
        'class_session_id',
        'scheduled_at',
        'given_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'given_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function availability()
    {
        return $this->belongsTo(InstructorAvailability::class, 'availability_id');
    }

    public function session()
    {
        return $this->belongsTo(ClassSession::class, 'class_session_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeGiven($query)
    {
        return $query->where('status', self::STATUS_GIVEN);
    }
}
