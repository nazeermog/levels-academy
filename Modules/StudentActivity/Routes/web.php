<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentActivity\Http\Controllers\ParenttController;
use Modules\StudentActivity\Http\Controllers\ParenttNotesController;
use Modules\StudentActivity\Http\Controllers\ParenttTransactionController;
use Modules\StudentActivity\Http\Controllers\ParenttAbsenceController;

Route::group([
    'middleware' => ['auth', 'role:parentt'],
    'prefix' => 'parentt',
], function () {
    Route::get('/dashboard', [ParenttController::class, 'showDashboard'])->name('parentt.dashboard');
    Route::get('/progressChilderns', [ParenttController::class, 'progressChilderns'])->name('parentt.progressChilderns');
    Route::get('/children-actions', [ParenttController::class, 'childrenEvents'])->name('parentt.childrenEvents');
    Route::get('/notes', [ParenttNotesController::class, 'childernNotes'])->name('parentt.notes.childernNotes');
    Route::post('/notes/{note}/check', [ParenttNotesController::class, 'check'])->name('parentt.notes.check');
    Route::get('/classroom-sessions', [ParenttNotesController::class, 'childrenClassroomSessions'])->name('parentt.classrooms.sessions');
    Route::get('/transactions', [ParenttTransactionController::class, 'transactions'])->name('parentt.transactions.index');
    Route::get('/transactions/pdf', [ParenttTransactionController::class, 'transactionsPdf'])->name('parentt.transactions.pdf');
    Route::get('addmoney', [ParenttTransactionController::class, 'showAddMoney'])->name('parentt.addmoney.show');
    Route::post('/add-money', [ParenttTransactionController::class, 'addMoney'])->name('parentt.addmoney');

    // Absences
    Route::get('/absences', [ParenttAbsenceController::class, 'index'])->name('parentt.absences.index');
    Route::get('/absences/create', [ParenttAbsenceController::class, 'create'])->name('parentt.absences.create');
    Route::post('/absences', [ParenttAbsenceController::class, 'store'])->name('parentt.absences.store');
});
