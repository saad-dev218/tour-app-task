<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('tours', TourController::class);
    Route::put('/tour-images/{id}', [TourController::class, 'updateImage'])->name('tour-images.update');

    Route::delete('/tour-images/{id}', [TourController::class, 'destroyImage'])->name('tour-images.destroy');
});
