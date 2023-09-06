<?php

use Illuminate\Support\Facades\Route;
use Modules\Inrollment\Http\Controllers\InrollmentController;


Route::group([
        'middleware' => ['auth', 'role:student'],
        'prefix' => 'student',
    ], function () {
        Route::prefix('inrollment')->group(function () {
            Route::get('', [InrollmentController::class, 'index'])->name('student.inrollment.index');
       
        });
    });