<?php

namespace DataSource\Entities\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = [
        'name',
        'desc',
    ];
}
