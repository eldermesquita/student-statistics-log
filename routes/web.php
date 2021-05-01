<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\Tests\TestsController;
use App\Http\Controllers\Users\ChangeRoleController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('courses', CoursesController::class)->only('index');

    Route::resource('courses', CoursesController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ])->middleware('can:manage-courses');

    Route::resource('tests', TestsController::class)->only('index', 'show');

    Route::resource('tests', TestsController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ])->middleware('can:manage-tests');

    Route::resource('users', UsersController::class)->only('index', 'create', 'store');
    Route::resource('users', UsersController::class)->only('create', 'store')->middleware('can:manage-users');
    Route::put('/users/{user}/change-role', ChangeRoleController::class)->name('users.role.change')->middleware('can:manage-users');
    Route::get('/users/workers', [UsersController::class, 'workers'])->name('users.workers');
});
