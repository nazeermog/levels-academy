<?php

namespace DataSource\Repositories\DB\Product\Admin;

use DataSource\Entities\Product\Product;
use DataSource\Entities\Semester\Semester;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminProductRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Product::class;

    public static function list()
    {
        return Product::all();
    }
}
