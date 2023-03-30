<?php

namespace Modules\DataResource\Entities\Practice;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    protected $table = 'practices';
    protected $fillable = ['course_id', 'title'];

}
