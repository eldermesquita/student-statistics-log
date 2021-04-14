<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\Users\ChangeRoleController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('courses', CoursesController::class)->only('index');

    Route::resource('courses', CoursesController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ])->middleware('can:manage-courses');

    Route::resource('tests', TestsController::class)->only('index');

    Route::resource('tests', TestsController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ])->middleware('can:manage-tests');

    Route::resource('users', UsersController::class)->only('index');
    Route::put('/users/{user}/change-role', ChangeRoleController::class)->name('users.role.change')->middleware('can:manage-users');
});
