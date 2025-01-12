<?php


use Illuminate\Support\Facades\Route;
use Modules\Taxonomy\Http\Controllers\Student\StudentTaxonomyController;

Route::group(['prefix' => 'student'], function () {
    Route::group(['prefix' => 'categories'], function () {
        Route::get('{GuestId}', [StudentTaxonomyController::class, 'list'])->name('student.categories.list');
    });
});
