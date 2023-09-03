<?php

use Illuminate\Support\Facades\Route;
use Modules\Lesson\Http\Controllers\LessonController;


Route::group([
   'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('lessons')->group(function () {
        Route::get('{lessonId}/show/course/{courseId}', [LessonController::class, 'show'])->name('student.lesson.show');

    });
});
