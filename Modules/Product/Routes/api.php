<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\Student\StudentCourseContentController;
use Modules\Course\Http\Controllers\Student\StudentCoursesController;


Route::group(['prefix' => 'student'], function () {
    Route::group(['prefix' => 'courses'], function () {
        Route::get('{categoryId}', [StudentCoursesController::class, 'list'])->name('student.courses.list');
        Route::get('content/{courseId}', [StudentCourseContentController::class, 'getCourseContent'])->name('student.courseContent.list');
        Route::get('content/{contentId}/show', [StudentCourseContentController::class, 'getContent'])->name('student.courseContent.list');
    });
});
