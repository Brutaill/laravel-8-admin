<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function() {
    Route::resource('/clients', ClientController::class);
    Route::resource('/projects', ProjectController::class);
    
    Route::put('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('task.complete');
    Route::resource('/tasks', TaskController::class);
    
    Route::put('/users/{user}/passwordChange', [UserController::class, 'passwordChange'])->name('user.passwordChange');
    Route::put('/users/{user}/projectsAssign', [UserController::class, 'projectsAssign'])->name('user.projectsAssign');
    Route::resource('/users', UserController::class);
    
    Route::put('/roles/{role}/assignPermissions', [RoleController::class, 'assignPermissions'])->name('role.assignPermissions');
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
});

require __DIR__.'/auth.php';
