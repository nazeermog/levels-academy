<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\StudentController;


Route::group([
    'middleware' => ['auth','role:student']
], function () {
    Route::get('/student/dashboard', [StudentController::class,'index'])->name('student.dashboard');
});
