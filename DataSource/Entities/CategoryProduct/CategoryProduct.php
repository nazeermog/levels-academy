<?php

namespace DataSource\Entities\CategoryProduct;

use DataSource\Entities\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryProduct extends BaseModel
{
    use Translatable,HasFactory;

    protected $table = 'category_products';

    public $translationForeignKey = 'category_product_id';
    protected $translatedAttributes = [
        'title',
        'desc',
    ];
    protected $fillable = [
        'is_active',        
    ];
}
