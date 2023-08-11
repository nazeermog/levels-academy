<?php

namespace DataSource\Entities\Instructor;

use Illuminate\Database\Eloquent\Model;

class InstructorTranslation extends Model
{
    protected $fillable = [
        'about',
        'spec',
        'country',
    ];
}
