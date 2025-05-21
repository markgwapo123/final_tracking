<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackTabInfoController;
use App\Http\Controllers\LoginActivityController;
use App\Http\Controllers\PcAccessController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Admin Login Page (custom login view)
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Shared)
|--------------------------------------------------------------------------
*/

// Regular and Admin Users - Shared Dashboard Controller
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

    // User-specific tab tracking
    Route::post('/track-tab-info', [TrackTabInfoController::class, 'store'])->name('track.tab');
    Route::post('/close-tab', [TrackTabInfoController::class, 'closeTab'])->name('close.tab');
    Route::post('/update-tab-title', [LoginActivityController::class, 'updateTabTitle']);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin-Only Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // You can add more admin-only routes here
});

/*
|--------------------------------------------------------------------------
| PC Access API (Unauthenticated API-style route)
|--------------------------------------------------------------------------
*/

Route::post('/pc/check-access', [PcAccessController::class, 'checkAccess']);

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze or Fortify)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
