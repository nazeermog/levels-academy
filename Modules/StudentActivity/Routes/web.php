<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentActivity\Http\Controllers\ParenttController;




Route::group([
    'middleware' => ['auth', 'role:parentt'],
    'prefix' => 'parentt',
], function () {
    Route::get('/dashboard', [ParenttController::class, 'showDashboard'])->name('parentt.dashboard');
    Route::get('/progressChilderns', [ParenttController::class, 'progressChilderns'])->name('parentt.progressChilderns');
    Route::get('/children-actions', [ParenttController::class, 'childrenEvents'])->name('parentt.childrenEvents');
    Route::get('/notes', [ParenttController::class, 'childernNotes'])->name('parentt.notes.childernNotes');
    Route::post('/notes/{note}/check', [ParenttController::class, 'check'])->name('parentt.notes.check');
    Route::get('/parent/transactions', [ParenttController::class, 'transactions'])->name('parentt.transactions.index');
});
