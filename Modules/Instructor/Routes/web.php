<?php


use Illuminate\Support\Facades\Route;
use Modules\Parentt\Http\Controllers\ParenttController;
use Modules\Instructor\Http\Controllers\InstructorController;

Route::group([
    'middleware' => ['auth', 'role:instructor']
], function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'index'])->name('instructor.dashboard');
    Route::get('/instructor/courses', [InstructorController::class, 'showInrollmentCourses'])->name('instructor.InrollmentCourses.index');
    Route::get('/instructor/studentscore', [InstructorController::class, 'showStudentScoreBoard'])->name('instructor.studentscore.index');
    Route::get('/instructor/studentscore/bycourse', [InstructorController::class, 'showStudentScoreBoardByFilter'])->name('studentscore.filter');
    Route::get('/instructor/enrolledStudentsEvents', [InstructorController::class, 'enrolledStudentsEvents'])->name('instructor.student.events');
});

Route::group([
    'middleware' => ['auth', 'role:student']
], function () {
    Route::get('/instructor/profile/{instructorId}', [InstructorController::class, 'showProfile'])->name('instructor.profile');
});
