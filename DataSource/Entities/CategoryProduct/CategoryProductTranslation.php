<?php

namespace DataSource\Entities\CategoryProduct;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductTranslation extends Model
{
    protected $fillable = [
        'title',
        'desc',
    ];
}
