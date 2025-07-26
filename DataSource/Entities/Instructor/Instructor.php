<?php

namespace DataSource\Entities\Instructor;

use DataSource\Entities\User\User;
use DataSource\Entities\Course\Course;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\BaseModel;

/**
 * @property integer $user_id
 * @property string $country
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Instructor extends BaseModel
{

    // protected $primaryKey = 'user_id';
    public $translationForeignKey = 'instructor_id';

    protected $translatedAttributes = [
        'about',
        'spec',
        'country',

    ];
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'avatar',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id', 'id');
    }
}
