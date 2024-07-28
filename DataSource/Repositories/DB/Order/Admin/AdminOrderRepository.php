<?php

namespace DataSource\Repositories\DB\Order\Admin;

use DataSource\Entities\Order\Order;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminOrderRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Order::class;

    public static function list()
    {
        return Order::all();
    }
    
}
