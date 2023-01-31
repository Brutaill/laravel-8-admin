<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PermissionController;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function() {
    Route::resource('/projects', ProjectController::class);
    Route::resource('/clients', ClientController::class);
    
    Route::put('/users/{user}/passwordChange', [UserController::class, 'passwordChange'])->name('users.passwordChange');
    Route::put('/users/{user}/projectsAssign', [UserController::class, 'projectsAssign'])->name('users.projectsAssign');
    Route::resource('/users', UserController::class);
    
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
});

require __DIR__.'/auth.php';
