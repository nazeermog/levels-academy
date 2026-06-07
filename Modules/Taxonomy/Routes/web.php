<?php


use Illuminate\Support\Facades\Route;
use DataSource\Http\Controllers\Admin\Order\AdminOrderController;
use Modules\Taxonomy\Http\Controllers\Student\StudentProductController;


Route::group([
  'middleware' => ['auth', 'role:student'],
  'prefix' => 'student',
], function () {
  Route::prefix('products')->group(function () {
    Route::get('index', [StudentProductController::class, 'index'])->name('student.index.products');
    Route::post('order/{ProductId}', [StudentProductController::class, 'store'])->name('student.products.order');
  });
});


// Follows the organizations master switch: admin manages orders only when orgs are OFF.
Route::group([
  'middleware' => ['auth', config('features.organizations') ? 'role:super_admin' : 'role:super_admin,admin'],
  'prefix' => 'admin',
], function () {
  Route::prefix('products')->group(function () {
    Route::post('order/accept/{orderId}', [AdminOrderController::class, 'acceptOrder'])->name('admin.orders.accept');
    Route::post('order/reject/{orderId}', [AdminOrderController::class, 'rejectOrder'])->name('admin.orders.reject');
  });
});
