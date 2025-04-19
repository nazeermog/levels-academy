<?php

namespace DataSource\Entities\Student;

use DataSource\Entities\User\User;
use DataSource\Entities\Order\Order;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Course\Rating;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\StudentScore\StudentScore;

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
    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'country',
        'city',
        'avatar',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function getRemainingCoins()
    {
        $totalCoins = StudentScore::where('student_id', $this->user_id)->sum('coin');
        $totalOrderPrices = Order::where('user_id', $this->user_id)->sum('price');
        return $totalCoins - $totalOrderPrices;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function parentts()
    {
        return $this->belongsToMany(Parentt::class, 'parentt_student', 'student_id', 'parentt_id');
    }
    public function inrollments()
    {
        return $this->hasMany(Inrollment::class, 'student_id');
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_students');
    }
    public function rateing()
    {
        return $this->hasMany(Rating::class);
    }
}
