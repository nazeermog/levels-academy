<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\ApiAuthController;

/*
|--------------------------------------------------------------------------
| Auth API Routes  (prefix: /api)
|--------------------------------------------------------------------------
|
| Passport-based JSON authentication for external applications.
|
*/

Route::prefix('auth')->group(function () {
    // Public endpoints
    Route::post('/register', [ApiAuthController::class, 'register'])->name('api.auth.register');
    Route::post('/login', [ApiAuthController::class, 'login'])->name('api.auth.login');

    // Protected endpoints (require a valid Passport access token)
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [ApiAuthController::class, 'me'])->name('api.auth.me');
        Route::post('/logout', [ApiAuthController::class, 'logout'])->name('api.auth.logout');
    });
});
