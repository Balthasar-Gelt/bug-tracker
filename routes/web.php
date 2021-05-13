<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BugStageController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\StageSerialNumberController;
use Illuminate\Support\Facades\Auth;

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

require __DIR__.'/auth.php';

Route::resource('projects', ProjectController::class)->middleware('auth');

Route::middleware(['auth', 'userProjects'])->group(function () {

    Route::resource('projects.project-user', ProjectUserController::class);
    Route::resource('projects.stages', StageController::class);
    Route::resource('projects.stages-serial-number', StageSerialNumberController::class);
    Route::resource('projects.stages.bugs', BugController::class);
    Route::resource('projects.stages.bug-stage', BugStageController::class);
});