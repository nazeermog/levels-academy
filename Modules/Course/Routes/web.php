<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\Student\StudentCourseController;

Route::group([
//    'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('courses')->group(function () {
        Route::get('', [StudentCourseController::class, 'index'])->name('student.courses.index');
    });
});
