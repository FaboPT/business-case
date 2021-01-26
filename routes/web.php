<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::any('register', function () {
    return redirect('/');
});

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('', [\App\Http\Controllers\UserController::class, 'index'])->name('user_index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('user_create');
        Route::post('/store', [\App\Http\Controllers\UserController::class, 'store'])->name('user_store');
        Route::get('/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('user_edit');
        Route::put('/{id}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('user_update');
        Route::delete('/{id}/delete', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user_delete');
    });
    Route::prefix('departments')->group(function () {
        Route::get('', [\App\Http\Controllers\DepartmentController::class, 'index'])->name('department_index');
        Route::get('/create', [\App\Http\Controllers\DepartmentController::class, 'create'])->name('department_create');
        Route::post('/store', [\App\Http\Controllers\DepartmentController::class, 'store'])->name('department_store');
        Route::get('/{id}/edit', [\App\Http\Controllers\DepartmentController::class, 'edit'])->name('department_edit');
        Route::put('/{id}/update', [\App\Http\Controllers\DepartmentController::class, 'update'])->name('department_update');
        Route::delete('/{id}/delete', [\App\Http\Controllers\DepartmentController::class, 'destroy'])->name('department_delete');
    });
});
Route::middleware(['auth', 'role:admin|simple'])->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::get('', [\App\Http\Controllers\TaskController::class, 'index'])->name('task_index');
        Route::get('/create', [\App\Http\Controllers\TaskController::class, 'create'])->name('task_create');
        Route::post('/store', [\App\Http\Controllers\TaskController::class, 'store'])->name('task_store');
        Route::get('/{id}/edit', [\App\Http\Controllers\TaskController::class, 'edit'])->name('task_edit');
        Route::put('/{id}/update', [\App\Http\Controllers\TaskController::class, 'update'])->name('task_update');
        Route::delete('/{id}/delete', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('task_delete');
    });
});



