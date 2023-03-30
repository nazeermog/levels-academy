<?php


use Illuminate\Support\Facades\Route;
use Modules\Taxonomy\Http\Controllers\Student\StudentTaxonomyController;

Route::group(['prefix' => 'student'], function () {
    Route::group(['prefix' => 'categories'], function () {
        Route::get('{partnerId}', [StudentTaxonomyController::class, 'list'])->name('student.categories.list');
    });
});
