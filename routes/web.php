<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TabTrackerController;
use App\Http\Controllers\PcLockController;
use App\Http\Controllers\TrackTabInfoController;
use App\Http\Controllers\LoginActivityController;
use Illuminate\Support\Facades\Route;

// PC Lock Routes
Route::post('/pc-login', [PcLockController::class, 'login']);
Route::post('/pc-logout', [PcLockController::class, 'logout']);

// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Track Tab Info Routes (with middleware)
Route::post('/track-tab-info', [TrackTabInfoController::class, 'store'])->middleware('auth');
Route::post('/track-tab-info', [TabTrackerController::class, 'store'])->middleware('auth');

// Update Tab Title Route (no middleware)
Route::post('/update-tab-title', [LoginActivityController::class, 'updateTabTitle']);

// Dashboard Routes with auth and verified middleware
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Profile Routes (auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth Routes
require __DIR__.'/auth.php';
