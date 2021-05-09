<?php

use App\Http\Controllers\Classrooms\StudentsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\Periods\PeriodsController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\Tests\TasksController;
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

    Route::get('courses/{course}/teachers', [CoursesController::class, 'teachers'])->name('courses.teachers');

    Route::resource('periods', PeriodsController::class);
    Route::put('/periods/{period}/activate', [PeriodsController::class, 'activate'])->name('periods.activate');

    Route::resource('classrooms', ClassroomsController::class)->except('store');
    Route::post('periods/{period}/classrooms', [ClassroomsController::class, 'store'])->name('classrooms.store');

    Route::get('/classrooms/{classroom}/students', [StudentsController::class, 'index'])->name('classrooms.students.index');
    Route::put('/students/{student}/transfer', [StudentsController::class, 'transfer'])->name('students.transfer');
    Route::post('/classrooms/{classroom}/students', [StudentsController::class, 'store'])->name('students.store');
    Route::resource('students', StudentsController::class)->only('update', 'destroy');
    Route::post('/students/import', [StudentsController::class, 'storeImport'])->name('students.import.store');
    Route::get('/students/import', [StudentsController::class, 'import'])->name('students.import');

    Route::resource('tests', TestsController::class);

    Route::resource('tests', TestsController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ])->middleware('can:manage-tests');

    Route::get('tests/{test}/tasks', [TasksController::class, 'index'])->name('tasks.index');

    Route::resource('users', UsersController::class)->only('index', 'create', 'store');
    Route::resource('users', UsersController::class)->only('create', 'store')->middleware('can:manage-users');
    Route::put('/users/{user}/change-role', ChangeRoleController::class)->name('users.role.change')->middleware('can:manage-users');
    Route::get('/users/workers', [UsersController::class, 'workers'])->name('users.workers');
});
