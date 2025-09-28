<?php

use Illuminate\Support\Facades\Route;
use DataSource\Http\Controllers\Admin\Blog\AdminBlogController;
use DataSource\Http\Controllers\Admin\Order\AdminOrderController;
use DataSource\Http\Controllers\Admin\Lesson\AdminLessonController;
use DataSource\Http\Controllers\Admin\Parentt\AdminParenttController;
use DataSource\Http\Controllers\Admin\Product\AdminProductController;
use DataSource\Http\Controllers\Admin\Student\AdminStudentController;
use DataSource\Http\Controllers\Admin\Exercise\AdminExerciseController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeController;
use DataSource\Http\Controllers\Admin\Semester\AdminSemesterController;
use DataSource\Http\Controllers\Admin\Taxonomy\AdminTaxonomyController;
use DataSource\Http\Controllers\Admin\Dashboard\AdminDashboardController;
use DataSource\Http\Controllers\Admin\CoursePath\AdminCoursePathController;
use DataSource\Http\Controllers\Admin\Inrollment\AdminInrollmentController;
use DataSource\Http\Controllers\Admin\Instructor\AdminInstructorController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeTypeController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeLevelController;
use DataSource\Http\Controllers\Admin\CourseContent\AdminCourseContentController;
use DataSource\Http\Controllers\Admin\ResultPractice\AdminResultPracticeController;
use DataSource\Http\Controllers\Admin\CategoryProduct\AdminCategoryProductController;
use DataSource\Http\Controllers\Admin\Instructor\AdminInstructorNoteController;


Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::group(['as' => 'admin.'], function () {
        Route::resource('courseContent', AdminCourseContentController::class);
        Route::resource('practices', AdminPracticeController::class);
        Route::resource('practicesType', AdminPracticeTypeController::class);
        Route::resource('Practiceslevels', AdminPracticeLevelController::class);
        Route::resource('taxonomies', AdminTaxonomyController::class);
        Route::resource('coursePath', AdminCoursePathController::class);
        Route::resource('lessons', AdminLessonController::class);
        Route::resource('instructors', AdminInstructorController::class);
        Route::resource('semesters', AdminSemesterController::class);
        Route::resource('students', AdminStudentController::class);
        Route::resource('parentts', AdminParenttController::class);
        Route::resource('exercises', AdminExerciseController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('categoryProducts', AdminCategoryProductController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::resource('blogs', AdminBlogController::class);
        Route::resource('inrollments', AdminInrollmentController::class);

        Route::get('resultPractices', [AdminResultPracticeController::class, 'index'])->name('resultPractices.index');
        Route::get('instructor-notes', [AdminInstructorNoteController::class, 'index'])->name('instructor-notes.index');
    });
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('students2/tiles', [AdminStudentController::class, 'tiles'])->name('admin.students2.tiles');

    Route::get('/students/import/form', [AdminStudentController::class, 'importform'])->name('admin.importstudents.form');
    Route::post('/students/import', [AdminStudentController::class, 'import'])->name('admin.students.import');

    Route::get('/students/csv/{filename}', function ($filename) {
        $path = storage_path("app/imports/{$filename}");
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }
        return response()->download($path);
    })->name('admin.download.csv');
});


Route::group([
    'middleware' => ['auth', 'role:admin']
], function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
