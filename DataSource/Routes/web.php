<?php

use DataSource\Http\Controllers\Admin\CourseContent\AdminCourseContentController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeTypeController;
use DataSource\Http\Controllers\Admin\ResultPractice\AdminResultPracticeController;
use Illuminate\Support\Facades\Route;


//Route::prefix('admin')->middleware(['auth'])->group(function () {
Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::resource('courseContent', AdminCourseContentController::class);
    Route::resource('practices', AdminPracticeController::class);
    Route::resource('practicesType', AdminPracticeTypeController::class);
    Route::get('resultPractices', [AdminResultPracticeController::class, 'index'])->name('resultPractices.index');
});
