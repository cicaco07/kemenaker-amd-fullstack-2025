<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\CheckupController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('owners', OwnerController::class);
Route::resource('pets', PetController::class);
Route::resource('checkups', CheckupController::class);
