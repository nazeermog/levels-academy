<?php

use Illuminate\Support\Facades\Route;
use Modules\PracticeType\Http\Controllers\PracticeController;
use Modules\PracticeType\Http\Controllers\StudentPracticeController;


//Route::group([
////    'middleware' => ['auth', 'role:instructor'],
//    ['as' => 'instructor.', 'prefix' => 'instructor'],
//], function () {
////        Route::get('create', [PracticeController::class, 'create'])->name('practice.create');
////        Route::post('create', [PracticeController::class, 'store'])->name('practice.store');
//        Route::resource('practice-details', PracticeController::class);
//});


Route::group(['as' => 'instructor.', 'prefix' => 'instructor'], function () {
    Route::resource('practice-details', PracticeController::class);
});
Route::group([
   'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('practice')->group(function () {
        Route::get('take-quiz/{id}', [StudentPracticeController::class, 'show'])->name('student.practice.take');
        Route::get('{id}/types/{type}', [StudentPracticeController::class, 'showPractice'])->name('student.practice.show');

        Route::get('forcourse/{id}/types/{type}/courses/{course}', [StudentPracticeController::class, 'practiceForCourse'])->name('student.practice.forcourse');

        Route::get('exercise', [StudentPracticeController::class, 'showAllExercises'])->name('student.index.exercise');
        Route::get('exercise/{id}/types/{type}', [StudentPracticeController::class, 'showExercise'])->name('student.show.exercise');
        Route::get('/check-exercise/{exerciseId}', [StudentPracticeController::class, 'checkExercise'])->name('check.exercise');



        Route::post('donePracitce/{practiceId}/course/{courseId}', [StudentPracticeController::class, 'donePracitce'])->name('student.practice.done');

        Route::get('/', [StudentPracticeController::class, 'index'])->name('student.practice.index');
        Route::get('/levels/{id}', [StudentPracticeController::class, 'showPracticeLevels'])->name('student.practice.levels');
        Route::post('resultPractice', [StudentPracticeController::class, 'sendResultPractice'])->name('student.practice.store');

        Route::get('results', [StudentPracticeController::class, 'showResultPractice'])->name('student.practice.results');


    });

});
