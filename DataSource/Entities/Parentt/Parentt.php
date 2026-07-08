<?php

namespace DataSource\Entities\Parentt;

use DataSource\Entities\User\User;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parentt extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'phone_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'parentt_student', 'parentt_id', 'student_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'parent_id');
    }
    public function balance()
    {
        $credits = $this->transactions()->where('is_credit', 1)->sum('price');
        $debits  = $this->transactions()->where('is_credit', 0)->sum('price');

        return $credits - $debits;
    }
}
