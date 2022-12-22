<?php


use Illuminate\Support\Facades\Route;


Route::get('/students', function () {
    return view('student.layouts.student');
});

Route::get('/instructors', function () {
    return view('instructor.layouts.instructor');
});

