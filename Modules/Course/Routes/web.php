<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\Student\StudentCourseController;
use Modules\Course\Http\Controllers\Student\StudentCourseRatingController;

Route::group([
    // 'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('courses')->group(function () {
        Route::get('', [StudentCourseController::class, 'index'])->name('student.courses.index');
        Route::get('show/{CourseId}', [StudentCourseController::class, 'show'])->name('student.courses.show');
        Route::post('rateCourse/{CourseId}', [StudentCourseRatingController::class, 'rateCourse'])->name('rate.course');

    });
});






