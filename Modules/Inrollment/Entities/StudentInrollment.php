<?php

namespace Modules\Inrollment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentInrollment extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Inrollment\Database\factories\StudentInrollmentFactory::new();
    }
}
