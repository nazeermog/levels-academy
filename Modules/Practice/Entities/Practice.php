<?php

namespace Modules\Practice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Practice extends Model
{
    protected $table = 'practices';
    protected $fillable = ['course_id', 'title'];

}
