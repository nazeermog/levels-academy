<?php

namespace DataSource\Repositories\DB\CategoryProduct\Admin;

use DataSource\Entities\Product\Product;
use DataSource\Entities\Semester\Semester;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;
use DataSource\Entities\CategoryProduct\CategoryProduct;

class AdminCategoryProductRepository
{
    use AdminCRUDGenericRepository;

    protected $model = CategoryProduct::class;

    public static function list()
    {
        return CategoryProduct::all();
    }
}
