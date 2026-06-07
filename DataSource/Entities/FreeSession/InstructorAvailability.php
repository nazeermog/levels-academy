<?php

namespace DataSource\Entities\FreeSession;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\User\User;

class InstructorAvailability extends Model
{
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_BOOKED = 'booked';

    protected $fillable = [
        'instructor_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }
}
