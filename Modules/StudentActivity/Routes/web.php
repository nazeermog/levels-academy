<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentActivity\Http\Controllers\ParenttController;
use Modules\StudentActivity\Http\Controllers\ParenttNotesController;
use Modules\StudentActivity\Http\Controllers\ParenttTransactionController;

Route::group([
    'middleware' => ['auth', 'role:parentt'],
    'prefix' => 'parentt',
], function () {
    Route::get('/dashboard', [ParenttController::class, 'showDashboard'])->name('parentt.dashboard');
    Route::get('/progressChilderns', [ParenttController::class, 'progressChilderns'])->name('parentt.progressChilderns');
    Route::get('/children-actions', [ParenttController::class, 'childrenEvents'])->name('parentt.childrenEvents');
    Route::get('/notes', [ParenttNotesController::class, 'childernNotes'])->name('parentt.notes.childernNotes');
    Route::post('/notes/{note}/check', [ParenttNotesController::class, 'check'])->name('parentt.notes.check');
    Route::get('/transactions', [ParenttTransactionController::class, 'transactions'])->name('parentt.transactions.index');
    Route::get('addmoney', [ParenttTransactionController::class, 'showAddMoney'])->name('parentt.addmoney.show');
    Route::post('/add-money', [ParenttTransactionController::class, 'addMoney'])->name('parentt.addmoney');
});
