<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUserController;

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

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('user/settings', [UserController::class, 'edit'])->name('user.settings');
    Route::patch('user', [UserController::class, 'update'])->name('user.update');

    Route::resource('projects', ProjectController::class);
});

Route::middleware(['auth', 'userProjects'])->group(function () {
    Route::resource('projects.project-user', ProjectUserController::class);
    Route::resource('projects.stages', StageController::class);
    Route::resource('projects.stages.bugs', BugController::class);

    Route::get('projects/{project}/users', [ProjectController::class, 'users'])->name('projects.users');
    Route::get('projects/{project}/bugs', [ProjectController::class, 'bugs'])->name('projects.bugs');
    Route::patch('projects/{project}/stages/{stage}/bugs/{bug}/update-position', [BugController::class, 'updatePosition'])->name('updatePosition');
});
