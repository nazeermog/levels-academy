<?php

namespace Modules\Instructor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

/**
 * @property integer $user_id
 * @property string $country
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Instructor extends Model
{
    protected $primaryKey = 'user_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
