<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PcLockController;
use App\Http\Controllers\PcAccessController;





Route::post('/unlock', [PcLockController::class, 'unlockFromElectron']);
Route::post('/pc-login', [PcLockController::class, 'login']);
Route::post('/pc-logout', [PcLockController::class, 'logout']);
Route::post('/pc/check-access', [PcAccessController::class, 'checkAccess']);
Route::post('/shutdown', [PcLockController::class, 'shutdown']);
