<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentActivity\Http\Controllers\ParenttController;


Route::prefix('studentactivity')->group(function() {
    Route::get('/', 'StudentActivityController@index');
});

Route::group([
    'middleware' => ['auth', 'role:parentt'],
    'prefix' => 'parentt',
], function () {
    Route::get('/dashboard', [ParenttController::class, 'showDashboard'])->name('parentt.dashboard');
    Route::get('/progressChilderns', [ParenttController::class, 'progressChilderns'])->name('parentt.progressChilderns');
    Route::get('/children-actions', [ParenttController::class, 'childrenEvents'])->name('parentt.childrenEvents');

});
