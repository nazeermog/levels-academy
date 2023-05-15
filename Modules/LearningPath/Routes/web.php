<?php

use Modules\LearningPath\Http\Controllers\LearningPathController;

Route::group([
//    'middleware' => ['auth', 'role:student'],
    'prefix' => 'student',
], function () {
    Route::prefix('paths')->group(function () {
        Route::get('', [LearningPathController::class, 'index'])->name('student.paths.index');

    });
});
