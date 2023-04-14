<?php

use DataSource\Http\Controllers\Admin\CourseContent\AdminCourseContentController;
use Illuminate\Support\Facades\Route;



//Route::prefix('admin')->middleware(['auth'])->group(function () {
Route::prefix('admin')->group(function () {
    Route::resource('courseContent', AdminCourseContentController::class);
});
