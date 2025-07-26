<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AdminUserEventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/user-events', [AdminUserEventController::class, 'eventindex'])->name('admin.userevents');
});
