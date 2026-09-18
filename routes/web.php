<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetRescueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PetRescueController::class, 'bienvenida'])
    ->name('bienvenida');

Route::get('/login', [AuthController::class, 'mostrarLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.guardar');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])
    ->name('registro');

Route::post('/registro', [AuthController::class, 'registrar'])
    ->name('registro.guardar');

Route::get('/inicio', [PetRescueController::class, 'inicio'])
    ->name('inicio');

Route::middleware('auth')->group(function () {
    Route::get('/reportes/perdida', [PetRescueController::class, 'crearReportePerdida'])
        ->name('reportes.perdida');

    Route::post('/reportes/perdida', [PetRescueController::class, 'guardarReportePerdida'])
        ->name('reportes.perdida.guardar');

    Route::get('/reportes/hallazgo', [PetRescueController::class, 'crearReporteHallazgo'])
        ->name('reportes.hallazgo');

    Route::post('/reportes/hallazgo', [PetRescueController::class, 'guardarReporteHallazgo'])
        ->name('reportes.hallazgo.guardar');

    Route::get('/perfil', [PetRescueController::class, 'perfil'])
        ->name('perfil');

    Route::put('/perfil/contacto', [PetRescueController::class, 'actualizarContacto'])
        ->name('perfil.contacto.actualizar');
});
