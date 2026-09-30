<?php

use App\Http\Controllers\Api\FreeSessionApiController;
use App\Http\Controllers\Api\WaAkgBotWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/whatsapp/bot', [WaAkgBotWebhookController::class, 'handle'])->name('api.whatsapp.bot');

// Free trial session requests (external app, Passport-authenticated users).
Route::middleware('auth:api')->prefix('free-sessions')->group(function () {
    Route::get('/', [FreeSessionApiController::class, 'index'])->name('api.free-sessions.index');
    Route::post('/', [FreeSessionApiController::class, 'store'])->name('api.free-sessions.store');
    Route::delete('/{freeSession}', [FreeSessionApiController::class, 'destroy'])->name('api.free-sessions.destroy');
});
