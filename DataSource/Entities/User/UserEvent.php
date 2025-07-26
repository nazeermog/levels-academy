<?php

namespace DataSource\Entities\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    use HasFactory;
    protected $table = 'user_events';   

    protected $fillable = [
        'user_id',
        'role',
        'action',
        'description',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
