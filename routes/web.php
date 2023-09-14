<?php


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

//
//Route::get('/students', function () {
//    return view('student.layouts.student');
//});
//
//Route::get('/instructors', function () {
//    return view('instructor.layouts.instructor');
//});
Route::middleware(['language'])->group(function () {

  Route::get('set-locale/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
  })->name('locale.setting');
});
