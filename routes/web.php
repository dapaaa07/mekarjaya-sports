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
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Player Management & Birth Year Export & Fast SPP Toggle & Print Rapor
    Route::get('/players/print-roster', [PlayerController::class, 'exportPrintable'])->name('players.print');
    Route::get('/players/{player}/print-rapor', [PlayerController::class, 'printRapor'])->name('players.print-rapor');
    Route::post('/players/{player}/toggle-spp', [PlayerController::class, 'toggleSpp'])->name('players.toggle-spp');
    Route::resource('players', PlayerController::class);

    // Manage Training Schedules (Kelola Jadwal Latihan)
    Route::resource('schedules', ScheduleController::class);

    // Online Registrations
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

    // Training Attendance Checklist
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');

    // Performance Evaluations (Spider/Radar Chart)
    Route::get('/players/{player}/evaluations/edit', [EvaluationController::class, 'edit'])->name('evaluations.edit');
    Route::post('/players/{player}/evaluations', [EvaluationController::class, 'update'])->name('evaluations.update');

    // Inventory & Equipment Management
    Route::resource('inventories', InventoryController::class)->only(['index', 'store', 'destroy']);

    // Match Center & Football Manager Tactical Pitch
    Route::get('/matches/{match}/tactics', [MatchController::class, 'tactics'])->name('matches.tactics');
    Route::post('/matches/{match}/tactics', [MatchController::class, 'updateTactics'])->name('matches.tactics.update');
    Route::resource('matches', MatchController::class)->only(['index', 'store', 'destroy']);
});
