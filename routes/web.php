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
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('permission:view_dashboard');

    Route::resource('roles', RoleController::class)->middleware('permission:manage_roles_and_permission');
    Route::resource('users', UserController::class)->middleware('permission:manage_users');
    Route::get('tours', [TourController::class, 'index'])
        ->name('tours.index')
        ->middleware('permission:view_tours');
    Route::get('tours/create', [TourController::class, 'create'])
        ->name('tours.create')
        ->middleware('permission:create_tour');

    Route::post('tours', [TourController::class, 'store'])
        ->name('tours.store')
        ->middleware('permission:create_tour');

    Route::get('tours/{tour}', [TourController::class, 'show'])
        ->name('tours.show')
        ->middleware('permission:view_tour_detail');

    Route::get('tours/{tour}/edit', [TourController::class, 'edit'])
        ->name('tours.edit')
        ->middleware('permission:edit_tour');

    Route::put('tours/{tour}', [TourController::class, 'update'])
        ->name('tours.update')
        ->middleware('permission:edit_tour');

    Route::delete('tours/{tour}', [TourController::class, 'destroy'])
        ->name('tours.destroy')
        ->middleware('permission:delete_tour');
    Route::put('tour-images/{id}', [TourController::class, 'updateImage'])
        ->name('tour-images.update')
        ->middleware('permission:edit_tour');

    Route::delete('tour-images/{id}', [TourController::class, 'destroyImage'])
        ->name('tour-images.destroy')
        ->middleware('permission:delete_tour');
});
