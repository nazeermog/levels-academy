<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentImportController;
use Modules\Student\Http\Controllers\StudentController;


Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
});
