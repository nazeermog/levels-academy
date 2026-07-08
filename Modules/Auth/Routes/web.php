<?php
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;


Route::prefix('auth')->group(function() {
    Route::get('/login', [AuthController::class,'index'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->middleware('throttle:10,1')->name('users.login');
    // GET so logout is a plain link — no CSRF token to go stale (avoids 419 "Page Expired").
    Route::get('/logout', [AuthController::class,'logout'])->name('users.logout');

});

