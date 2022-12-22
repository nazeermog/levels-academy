<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = [
        'title',
        'slug',
        'desc',
        'price',
    ];
}
