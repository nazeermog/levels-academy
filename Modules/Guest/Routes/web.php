<?php
use Modules\Guest\Http\Controllers\GuestController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;

Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::get('blog/show/{blogid}', [GuestController::class, 'show_blog'])->name('blog.show');
