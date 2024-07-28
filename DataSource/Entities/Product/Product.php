<?php

namespace DataSource\Entities\Product;

use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\BaseModel;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use Translatable,HasFactory;

    protected $table = 'products';

    public $translationForeignKey = 'product_id';
    protected $translatedAttributes = [
        'name',
        'desc',
    ];
    protected $fillable = [
        'price',
        'photo',
        'is_active',      
        'unit',  
        'category_product_id',  
    ];
}
