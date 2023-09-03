<?php
use Illuminate\Support\Facades\Route;
use Modules\ResultPractice\Http\Controllers\ResultPracticeController;

Route::group(['as' => 'instructor.', 'prefix' => 'instructor'], function () {

    Route::get('result-practice', [ResultPracticeController::class,'index'])->name('result-practice.index');

});
