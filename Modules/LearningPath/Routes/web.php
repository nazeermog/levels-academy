<?php

use Illuminate\Support\Facades\Route;
use Modules\LearningPath\Http\Controllers\LearningPathController;

Route::group([
//    'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('paths')->group(function () {
        Route::get('', [LearningPathController::class, 'index'])->name('student.paths.index');
        Route::get('show/{pathId}', [LearningPathController::class, 'show'])->name('student.path.show');

    });
});
