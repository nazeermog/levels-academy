<?php

use Illuminate\Support\Facades\Route;
use DataSource\Http\Controllers\Admin\Lesson\AdminLessonController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeController;
use DataSource\Http\Controllers\Admin\Taxonomy\AdminTaxonomyController;
use DataSource\Http\Controllers\Admin\CoursePath\AdminCoursePathController;
use DataSource\Http\Controllers\Admin\Instructor\AdminInstructorController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeTypeController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeLevelController;
use DataSource\Http\Controllers\Admin\CourseContent\AdminCourseContentController;
use DataSource\Http\Controllers\Admin\ResultPractice\AdminResultPracticeController;


//Route::prefix('admin')->middleware(['auth'])->group(function () {
Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::resource('courseContent', AdminCourseContentController::class);
    Route::resource('practices', AdminPracticeController::class);
    Route::resource('practicesType', AdminPracticeTypeController::class);
    Route::resource('taxonomies', AdminTaxonomyController::class);
    Route::resource('coursePath', AdminCoursePathController::class);
    Route::resource('lessons', AdminLessonController::class);
    Route::resource('instructors', AdminInstructorController::class);
    Route::resource('Practiceslevels', AdminPracticeLevelController::class);

    Route::get('resultPractices', [AdminResultPracticeController::class, 'index'])->name('resultPractices.index');
});
