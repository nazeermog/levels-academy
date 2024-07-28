<?php

namespace DataSource\Entities\Order;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use DataSource\Entities\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
    'product_id',
    'user_id',
    'status',
    'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
