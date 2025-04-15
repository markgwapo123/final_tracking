<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackTabInfoController;
use App\Http\Controllers\LoginActivityController;
use App\Http\Controllers\PcLockController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| PC Lock API Routes
|--------------------------------------------------------------------------
*/

Route::post('/pc-login', [PcLockController::class, 'login']);
Route::post('/pc-logout', [PcLockController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Track tab activity with named routes
    Route::post('/track-tab-info', [TrackTabInfoController::class, 'store'])
        ->name('track.tab');  // Added route name here
    
    Route::post('/close-tab', [TrackTabInfoController::class, 'closeTab'])
        ->name('close.tab');

    // Update tab title
    Route::post('/update-tab-title', [LoginActivityController::class, 'updateTabTitle']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze or Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';