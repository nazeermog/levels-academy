<?php
Route::group(['as' => 'instructor.', 'prefix' => 'instructor'], function () {

    Route::get('result-practice', [\Modules\ResultPractice\Http\Controllers\ResultPracticeController::class,'index'])->name('result-practice.index');

});
