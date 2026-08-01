<?php


use Illuminate\Support\Facades\Route;
use Modules\Parentt\Http\Controllers\ParenttController;
use Modules\Instructor\Http\Controllers\InstructorController;
use Modules\Instructor\Http\Controllers\InstructorNoteController;
use Modules\Instructor\Http\Controllers\ClassSessionController;
use Modules\Instructor\Http\Controllers\InstructorPayoutReportController;
use Modules\Instructor\Http\Controllers\ExpectedEarningsReportController;
use Modules\Instructor\Http\Controllers\InstructorAvailabilityController;
use Modules\Instructor\Http\Controllers\InstructorFreeSessionController;
use Modules\Instructor\Http\Controllers\InstructorCourseProgressController;
use Modules\Instructor\Http\Controllers\InstructorMyCoursesController;

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

    // Free-session availability (the instructor's open time slots)
    Route::get('/availability', [InstructorAvailabilityController::class, 'index'])->name('instructor.availability.index');
    Route::post('/availability', [InstructorAvailabilityController::class, 'store'])->name('instructor.availability.store');
    Route::delete('/availability/{availability}', [InstructorAvailabilityController::class, 'destroy'])->name('instructor.availability.destroy');

    // Free sessions assigned to this instructor
    Route::get('/free-sessions', [InstructorFreeSessionController::class, 'index'])->name('instructor.free-sessions.index');
    Route::post('/free-sessions/{freeSession}/given', [InstructorFreeSessionController::class, 'markGiven'])->name('instructor.free-sessions.given');

    // Classroom sessions
    Route::get('/sessions', [ClassSessionController::class, 'index'])->name('instructor.sessions.index');
    Route::get('/sessions/events', [ClassSessionController::class, 'events'])->name('instructor.sessions.events');
    Route::get('/sessions/create', [ClassSessionController::class, 'create'])->name('instructor.sessions.create');
    Route::post('/sessions', [ClassSessionController::class, 'store'])->name('instructor.sessions.store');
    Route::get('/sessions/{session}/edit', [ClassSessionController::class, 'edit'])->name('instructor.sessions.edit');
    Route::put('/sessions/{session}', [ClassSessionController::class, 'update'])->name('instructor.sessions.update');

    // Given history: every session this instructor delivered, per student, with earnings
    Route::get('/sessions/history', [ClassSessionController::class, 'history'])->name('instructor.sessions.history');

    // Per-student attendance: mark each student's session given (+ note) → charges parent, credits instructor
    Route::get('/sessions/{session}/attendance', [ClassSessionController::class, 'attendance'])->name('instructor.sessions.attendance');
    Route::post('/sessions/{session}/students/{student}/given', [ClassSessionController::class, 'markStudentGiven'])->name('instructor.sessions.student.given');

    // My Courses — instructor edits the courses they teach (same builder as admin)
    Route::get('/my-courses', [InstructorMyCoursesController::class, 'index'])->name('instructor.mycourses.index');
    Route::get('/my-courses/{course}/edit', [InstructorMyCoursesController::class, 'edit'])->name('instructor.mycourses.edit');
    Route::put('/my-courses/{course}', [InstructorMyCoursesController::class, 'update'])->name('instructor.mycourses.update');

    // Course progress (per-student, per-step)
    Route::get('/progress', [InstructorCourseProgressController::class, 'index'])->name('instructor.progress.index');
    Route::get('/progress/{course}', [InstructorCourseProgressController::class, 'show'])->name('instructor.progress.show');

    // Reports
    Route::get('/reports/per-student-payout', [InstructorPayoutReportController::class, 'perStudent'])->name('instructor.reports.per_student');
    Route::get('/reports/per-student-payout/pdf', [InstructorPayoutReportController::class, 'perStudentPdf'])->name('instructor.reports.per_student.pdf');
    Route::get('/reports/expected-earnings', [ExpectedEarningsReportController::class, 'index'])->name('instructor.reports.expected_earnings');
});

Route::group([
    'middleware' => ['auth', 'role:student']
], function () {
    Route::get('/instructor/profile/{instructorId}', [InstructorController::class, 'showProfile'])->name('instructor.profile');
});
