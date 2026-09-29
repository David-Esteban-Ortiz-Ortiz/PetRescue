<?php

use App\Http\Controllers\PetRescueController;
use App\Http\Controllers\PublicacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PetRescueController::class, 'bienvenida'])
    ->name('bienvenida');

Route::get('/inicio', [PetRescueController::class, 'inicio'])
    ->name('inicio');

Route::get('/reportes/perdida', [PetRescueController::class, 'crearReportePerdida'])
    ->name('reportes.perdida');

Route::post('/reportes/perdida', [PetRescueController::class, 'guardarReportePerdida'])
    ->name('reportes.perdida.guardar');

Route::get('/reportes/hallazgo', [PetRescueController::class, 'crearReporteHallazgo'])
    ->name('reportes.hallazgo');

Route::post('/reportes/hallazgo', [PetRescueController::class, 'guardarReporteHallazgo'])
    ->name('reportes.hallazgo.guardar');

Route::get('/reportes/confirmacion', [PetRescueController::class, 'mostrarConfirmacion'])
    ->name('reportes.confirmacion');

Route::get('/reportes/actualizar-contacto', [PetRescueController::class, 'mostrarFormularioActualizarContacto'])
    ->name('reportes.actualizar-contacto');

Route::post('/reportes/verificar-codigos', [PetRescueController::class, 'verificarCodigos'])
    ->name('reportes.verificar-codigos');

Route::put('/reportes/{codigoReporte}/contacto', [PetRescueController::class, 'actualizarContacto'])
    ->name('reportes.contacto.actualizar');

Route::get('/reportes/{codigoReporte}', [PetRescueController::class, 'mostrarReporte'])
    ->name('reportes.detalle');

Route::prefix('comunidad')->name('comunidad.')->group(function () {
    Route::get('/', [PublicacionController::class, 'index'])
        ->name('index');

    Route::get('/publicar', [PublicacionController::class, 'crear'])
        ->name('crear');

    Route::post('/publicaciones', [PublicacionController::class, 'guardar'])
        ->name('guardar');

    Route::get('/publicaciones/{codigoPublicacion}', [PublicacionController::class, 'detalle'])
        ->name('detalle');
});
