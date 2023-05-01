<?php

use Illuminate\Support\Facades\Route;
use Modules\PracticeType\Http\Controllers\PracticeController;
use Modules\PracticeType\Http\Controllers\StudentPracticeController;


Route::group([
//    'middleware' => ['auth', 'role:instructor'],
    'prefix' => 'instructor',
], function () {
    Route::prefix('practice')->group(function () {
        Route::get('create', [PracticeController::class, 'create'])->name('practice.create');
        Route::post('create', [PracticeController::class, 'store'])->name('practice.store');
    });

});
Route::group([
//    'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('practice')->group(function () {
        Route::get('take-quiz/{id}', [StudentPracticeController::class, 'show'])->name('student.practice.take');
        Route::get('{id}', [StudentPracticeController::class, 'showPractice'])->name('student.practice.show');
        Route::post('resultPractice', [StudentPracticeController::class, 'sendResultPractice'])->name('student.practice.store');
    });

});
