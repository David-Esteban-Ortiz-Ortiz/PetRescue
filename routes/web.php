<?php

use App\Http\Controllers\PetRescueController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// ==========================================
// RUTAS PÚBLICAS (Cualquiera puede verlas)
// ==========================================

Route::get('/', [PetRescueController::class, 'bienvenida'])->name('bienvenida');
Route::get('/inicio', [PetRescueController::class, 'inicio'])->name('inicio');

// Rutas de Autenticación (Login, Registro)
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.guardar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.guardar');

// Formularios de Reportes (Públicos para que los vean, pero no para guardar)
Route::get('/reportes/perdida', [PetRescueController::class, 'crearReportePerdida'])->name('reportes.perdida');
Route::get('/reportes/hallazgo', [PetRescueController::class, 'crearReporteHallazgo'])->name('reportes.hallazgo');
Route::get('/reportes/confirmacion', [PetRescueController::class, 'mostrarConfirmacion'])->name('reportes.confirmacion');
Route::get('/reportes/actualizar-contacto', [PetRescueController::class, 'mostrarFormularioActualizarContacto'])->name('reportes.actualizar-contacto');
Route::get('/reportes/{codigoReporte}', [PetRescueController::class, 'mostrarReporte'])->name('reportes.detalle');

// Comunidad (Pública para leer)
Route::prefix('comunidad')->name('comunidad.')->group(function () {
    Route::get('/', [PublicacionController::class, 'index'])->name('index');
    Route::get('/publicar', [PublicacionController::class, 'crear'])->name('crear');
    Route::get('/publicaciones/{codigoPublicacion}', [PublicacionController::class, 'detalle'])->name('detalle');
});


// ==========================================
// RUTAS PROTEGIDAS (Solo usuarios logueados)
// ==========================================

Route::middleware('auth')->group(function () {

    // Perfil del usuario
    Route::get('/perfil', [AuthController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [AuthController::class, 'actualizarPerfil'])->name('perfil.actualizar');

    // Guardar Reportes (HU1 y HU2)
    Route::post('/reportes/perdida', [PetRescueController::class, 'guardarReportePerdida'])->name('reportes.perdida.guardar');
    Route::post('/reportes/hallazgo', [PetRescueController::class, 'guardarReporteHallazgo'])->name('reportes.hallazgo.guardar');

    // Actualizar contacto por código (HU3)
    Route::post('/reportes/verificar-codigos', [PetRescueController::class, 'verificarCodigos'])->name('reportes.verificar-codigos');
    Route::put('/reportes/{codigoReporte}/contacto', [PetRescueController::class, 'actualizarContacto'])->name('reportes.contacto.actualizar');

    // Guardar Publicación (HU5)
    Route::post('/comunidad/publicaciones', [PublicacionController::class, 'guardar'])->name('comunidad.guardar');

    // Guardar Comentarios (HU6)
    Route::post('/publicaciones/{publicacion}/comentarios', [PublicacionController::class, 'guardarComentario'])->name('comentarios.publicacion.guardar');
    Route::post('/reportes/{reporte}/comentarios', [PetRescueController::class, 'guardarComentario'])->name('comentarios.reporte.guardar');

    // ==========================================
    // RUTAS NUEVAS DEL SPRINT 4 (HU8 y HU9)
    // ==========================================

    // Panel de Administrador (HU8)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::put('/ocultar/{tipo}/{id}', [AdminController::class, 'ocultar'])->name('ocultar');
    });

    // Resolver Reporte (HU9)
    Route::put('/reportes/{codigoReporte}/resolver', [PetRescueController::class, 'resolverReporte'])->name('reportes.resolver');

});
