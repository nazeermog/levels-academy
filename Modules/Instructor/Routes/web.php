<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Instructor\Http\Controllers\InstructorController;

Route::group([
    'middleware' => ['auth','role:instructor']
], function () {
    Route::get('/instructor/dashboard', [InstructorController::class,'index'])->name('instructor.dashboard');
    Route::get('/instructor/courses', [InstructorController::class,'showInrollmentCourses'])->name('instructor.InrollmentCourses.index');
    Route::get('/instructor/studentscore', [InstructorController::class,'showStudentScoreBoard'])->name('instructor.studentscore.index');
});
