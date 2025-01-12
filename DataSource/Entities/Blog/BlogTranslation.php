<?php

namespace DataSource\Entities\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    protected $fillable = [
        'title',
        'desc',
    ];

}
