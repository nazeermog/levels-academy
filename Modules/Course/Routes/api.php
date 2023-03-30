<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\Student\StudentCoursesController;


Route::group(['prefix' => 'student'], function () {
    Route::group(['prefix' => 'courses'], function () {
        Route::get('{categoryId}', [StudentCoursesController::class, 'list'])->name('student.courses.list');
    });
});
