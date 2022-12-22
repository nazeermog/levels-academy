<?php
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;


Route::prefix('auth')->group(function() {
    Route::get('/login', 'AuthController@index')->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('users.login');
});

