<?php

use Illuminate\Support\Facades\Route;
use Modules\Lesson\Http\Controllers\LessonController;
use Modules\StudentActivity\Http\Controllers\ParenttController;


Route::group([
   'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('lessons')->group(function () {
        Route::get('{lessonId}/show/course/{courseId}', [LessonController::class, 'show'])->name('student.lesson.show');
        Route::post('watch/{lessonId}/course/{courseId}', [LessonController::class, 'watched'])->name('student.lesson.watched');
    });
});

Route::group([
    'middleware' => ['auth', 'role:parentt'],
    'prefix' => 'parentt',
], function () {
    Route::get('/dashboard', [ParenttController::class, 'showDashboard'])->name('parentt.dashboard');
    Route::get('/progressChilderns', [ParenttController::class, 'progressChilderns'])->name('parentt.progressChilderns');

});
