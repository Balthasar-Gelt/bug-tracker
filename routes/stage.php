<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StageController;

Route::post('/stages', [StageController::class, 'store'])->name('stage.store');