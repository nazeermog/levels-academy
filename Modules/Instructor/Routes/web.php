<?php


use Illuminate\Support\Facades\Route;
use Modules\Parentt\Http\Controllers\ParenttController;
use Modules\Instructor\Http\Controllers\InstructorController;
use Modules\Instructor\Http\Controllers\InstructorNoteController;
use Modules\Instructor\Http\Controllers\ClassSessionController;
use Modules\Instructor\Http\Controllers\InstructorPayoutReportController;

Route::group([
    'prefix' => 'instructor',
    'middleware' => ['auth', 'role:instructor']
], function () {
    Route::get('/dashboard', [InstructorController::class, 'index'])->name('instructor.dashboard');
    Route::get('/courses', [InstructorController::class, 'showInrollmentCourses'])->name('instructor.InrollmentCourses.index');
    Route::get('/studentscore', [InstructorController::class, 'showStudentScoreBoard'])->name('instructor.studentscore.index');
    Route::get('/studentscore/bycourse', [InstructorController::class, 'showStudentScoreBoardByFilter'])->name('studentscore.filter');
    Route::get('/enrolledStudentsEvents', [InstructorController::class, 'enrolledStudentsEvents'])->name('instructor.student.events');
    Route::post('/notes', [InstructorNoteController::class, 'store'])->name('instructor.notes.store');

    Route::get('/notes', [InstructorNoteController::class, 'index'])->name('instructor.notes.index');
    Route::get('/notes/create', [InstructorNoteController::class, 'create'])->name('instructor.notes.create');
    Route::get('/notes/edit/{id}', [InstructorNoteController::class, 'edit'])->name('instructor.notes.edit');
    Route::get('/notes/destroy/{id}', [InstructorNoteController::class, 'destroy'])->name('instructor.notes.destroy');
    Route::put('/notes/update/{id}', [InstructorNoteController::class, 'update'])->name('instructor.notes.update');

    Route::post('/notes', [InstructorNoteController::class, 'store'])->name('instructor.notes.store');

    // Classroom sessions
    Route::get('/sessions', [ClassSessionController::class, 'index'])->name('instructor.sessions.index');
    Route::get('/sessions/create', [ClassSessionController::class, 'create'])->name('instructor.sessions.create');
    Route::post('/sessions', [ClassSessionController::class, 'store'])->name('instructor.sessions.store');
    Route::get('/sessions/{session}/edit', [ClassSessionController::class, 'edit'])->name('instructor.sessions.edit');
    Route::put('/sessions/{session}', [ClassSessionController::class, 'update'])->name('instructor.sessions.update');

    // Reports
    Route::get('/reports/per-student-payout', [InstructorPayoutReportController::class, 'perStudent'])->name('instructor.reports.per_student');
});

Route::group([
    'middleware' => ['auth', 'role:student']
], function () {
    Route::get('/instructor/profile/{instructorId}', [InstructorController::class, 'showProfile'])->name('instructor.profile');
});
