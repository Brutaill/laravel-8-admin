<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard/{id}', [DashboardController::class, 'update'])->middleware(['auth'])->name('dashboard.update');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function() {
    
    Route::get('/clients/archive', [ClientController::class, 'archive'])->name('clients.archive');
    Route::put('/clients/archive/{client}/restore', [ClientController::class, 'restore'])->name('client.restore')->withTrashed();
    Route::delete('/clients/archive/{client}/delete', [ClientController::class, 'forceDelete'])->name('client.forceDelete')->withTrashed();
    Route::get('/clients/archive', [ClientController::class, 'archive'])->name('clients.archive');
    Route::resource('/clients', ClientController::class);
    
    Route::get('/projects/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::put('/projects/archive/{project}/restore', [ProjectController::class, 'restore'])->name('project.restore')->withTrashed();
    Route::delete('/projects/archive/{project}/delete', [ProjectController::class, 'forceDelete'])->name('project.forceDelete')->withTrashed();
    Route::get('/projects/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::resource('/projects', ProjectController::class);
    
    Route::get('/tasks/archive', [TaskController::class, 'archive'])->name('tasks.archive');
    Route::put('/tasks/archive/{task}/restore', [TaskController::class, 'restore'])->name('task.restore')->withTrashed();
    Route::delete('/tasks/archive/{task}/delete', [TaskController::class, 'forceDelete'])->name('task.forceDelete')->withTrashed();
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
