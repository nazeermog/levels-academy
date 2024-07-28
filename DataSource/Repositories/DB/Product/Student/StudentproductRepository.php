<?php

namespace DataSource\Repositories\DB\product\Student;

use DataSource\Entities\Product\Product;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class StudentproductRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Product::class;

    public static function list()
    {
        return Product::all();
    }
}
