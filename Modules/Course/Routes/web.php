<?php

use Illuminate\Support\Facades\Route;
use Modules\Instructor\Http\Controllers\InstructorController;
use Modules\Course\Http\Controllers\Student\StudentCourseController;
use Modules\Course\Http\Controllers\Student\StudentCourseRatingController;
use Modules\Course\Http\Controllers\Student\StudentWorksheetController;

Route::group([
    'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('courses')->group(function () {
        Route::get('', [StudentCourseController::class, 'index'])->name('student.courses.index');
        Route::get('show/{CourseId}', [StudentCourseController::class, 'show'])->name('student.courses.show');
        Route::post('rateCourse/{CourseId}', [StudentCourseRatingController::class, 'rateCourse'])->name('rate.course');

    });

    // Opening a worksheet marks it read (counts toward progress) then serves the file.
    Route::get('worksheets/{worksheetId}/open/course/{courseId}', [StudentWorksheetController::class, 'open'])
        ->name('student.worksheet.open');

    // Clicking a link marks it complete (counts toward progress) then redirects to the URL.
    Route::get('links/{linkId}/open/course/{courseId}', [StudentWorksheetController::class, 'openLink'])
        ->name('student.link.open');
});






