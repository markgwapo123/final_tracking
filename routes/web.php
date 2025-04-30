<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackTabInfoController;
use App\Http\Controllers\LoginActivityController;
use App\Http\Controllers\PcLockController;
use App\Http\Controllers\PcAccessController;
use App\Http\Controllers\Admin\AdminController; // ✅ Fixed this line

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ✅ Admin Login Page Route
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

// ✅ Admin Dashboard - protected with auth & admin middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/track-tab-info', [TrackTabInfoController::class, 'store'])->name('track.tab');
    Route::post('/close-tab', [TrackTabInfoController::class, 'closeTab'])->name('close.tab');

    Route::post('/update-tab-title', [LoginActivityController::class, 'updateTabTitle']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Optional: PC Access API
Route::post('/pc/check-access', [PcAccessController::class, 'checkAccess']);

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze or Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
