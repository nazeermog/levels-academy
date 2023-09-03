<?php

namespace Modules\Inrollment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inrollment\Database\factories\StudentInrollmentFactory;

class StudentInrollment extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return StudentInrollmentFactory::new();
    }
}
