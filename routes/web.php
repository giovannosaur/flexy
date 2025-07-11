<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlexyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ApprovalController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/checkin', [AttendanceController::class, 'checkin'])->name('checkin');

    // Flexy
    Route::get('/flexy/request', [FlexyController::class, 'create'])->name('flexy.request');
    Route::post('/flexy/request', [FlexyController::class, 'store']);
    
    // Jadwal
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/changed-schedule', [ScheduleController::class, 'changed'])->name('changed.schedule');
    Route::get('/history', [AttendanceController::class, 'history'])->name('history');
});

Route::middleware(['auth', 'role:Level 2,Level 3'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', function () {
        // Kirim greeting ke blade kalau mau, atau langsung return view
        $hour = now()->format('H');
        if ($hour >= 5 && $hour < 11) {
            $greet = 'Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greet = 'Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greet = 'Sore';
        } else {
            $greet = 'Malam';
        }
        return view('admin.dashboard', compact('greet'));
    })->name('dashboard');

    Route::get('/absensi', [AdminAbsensiController::class, 'index'])->name('absensi');
    
    Route::get('/approval', [ApprovalController::class, 'index'])->name('approval');
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{id}/deny', [ApprovalController::class, 'deny'])->name('approval.deny');
});


Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');