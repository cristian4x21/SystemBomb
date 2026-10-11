<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuditController;

Route::get('/', fn () => redirect()->route('dashboard'));
Route::middleware('guest')->group(function () {
    Route::get('/iniciar-sesion', [AuthController::class, 'show'])->name('login');
    Route::post('/iniciar-sesion', [AuthController::class, 'login'])->name('login.submit');
});
Route::middleware('auth')->group(function () {
    Route::post('/salir', [AuthController::class, 'logout'])->name('logout');
    Route::get('/panel', DashboardController::class)->name('dashboard');
    Route::get('/recursos', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/recursos/nuevo', [ResourceController::class, 'create'])->name('resources.create');
    Route::post('/recursos', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/recursos/{resource}/editar', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/recursos/{resource}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/recursos/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');

    Route::get('/asignaciones', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/asignaciones/nueva', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/asignaciones', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::patch('/asignaciones/{assignment}/devolver', [AssignmentController::class, 'return'])->name('assignments.return');

    Route::get('/vehiculos', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehiculos/nuevo', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehiculos', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehiculos/{vehicle}/editar', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehiculos/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::get('/auditoria', AuditController::class)->name('audits.index');
});
