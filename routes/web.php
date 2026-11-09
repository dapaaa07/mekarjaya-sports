<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ScheduleController;

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portal-ortu', [HomeController::class, 'parentPortal'])->name('parent.portal');
Route::post('/register-siswa', [HomeController::class, 'storeRegistration'])->name('public.register');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::middleware('role:admin,coach')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // In-App Notifications
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

        // Manage Training Schedules (Kelola Jadwal Latihan)
        Route::resource('schedules', ScheduleController::class);

        // Training Attendance Checklist
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');

        // Performance Evaluations (Spider/Radar Chart & History)
        Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::get('/players/{player}/evaluations/edit', [EvaluationController::class, 'edit'])->name('evaluations.edit');
        Route::post('/players/{player}/evaluations', [EvaluationController::class, 'update'])->name('evaluations.update');

        // Match Center Pertandingan
        Route::resource('matches', MatchController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
    });

    Route::middleware('role:admin')->group(function () {
        // Player Management & Birth Year Export & SPP Payment Ledger & Print Rapor
        Route::get('/players/print-roster', [PlayerController::class, 'exportPrintable'])->name('players.print');
        Route::get('/players/{player}/print-rapor', [PlayerController::class, 'printRapor'])->name('players.print-rapor');
        Route::post('/players/{player}/spp-payments', [PlayerController::class, 'storeSppPayment'])->name('players.spp-payments.store');
        Route::delete('/players/{player}/spp-payments/{sppPayment}', [PlayerController::class, 'destroySppPayment'])->name('players.spp-payments.destroy');
        Route::resource('players', PlayerController::class);

        // Online Registrations
        Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
        Route::post('/registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
        Route::post('/registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

        // Inventory & Equipment Management
        Route::resource('inventories', InventoryController::class)->only(['index', 'store', 'destroy']);
    });
});
