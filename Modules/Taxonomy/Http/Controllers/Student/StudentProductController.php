<?php

namespace Modules\Taxonomy\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use DataSource\Entities\Order\Order;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Product\Product;
use DataSource\Entities\StudentScore\StudentScore;
use DataSource\Repositories\DB\Product\Student\StudentproductRepository;
use DataSource\Repositories\DB\CategoryProduct\Admin\AdminCategoryProductRepository;


class StudentProductController extends Controller
{

  public function index()
  {
    $products = StudentproductRepository::list();
    $categories = AdminCategoryProductRepository::list();
    return view('taxonomy::index', compact('products', 'categories'));
  }
  public function store($ProductId)
  {
    $product = Product::find($ProductId);
    $studentId = Auth::id();

    $totalCoins = StudentScore::where('student_id', $studentId)->sum('coin');
    $totalOrdersPrice = Order::where('user_id', $studentId)->sum('price');

    $totalCostWithNewOrder = $totalOrdersPrice + $product->price;
    
    if ($totalCoins >= $totalCostWithNewOrder) {
      Order::create([
        'product_id' => $product->id,
        'user_id' => $studentId,
        'status' => 'pending',
        'price' => $product->price,
      ]);

      return redirect()->back()->with('success', 'Order placed successfully!');
    } else {
      return redirect()->back()->with('error', 'You do not have enough coins to place this order.');
    }
  }
}
