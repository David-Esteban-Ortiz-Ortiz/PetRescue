<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Models\Reporte;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Buscamos todas las publicaciones y reportes en la base de datos
        $publicaciones = Publicacion::orderBy('id', 'desc')->get();
        $reportes = Reporte::orderBy('id', 'desc')->get();

        // Enviamos las variables a la vista
        return view('admin.dashboard', compact('publicaciones', 'reportes'));
    }

    public function ocultar($tipo, $id)
    {
        if ($tipo === 'publicacion') {
            $publicacion = Publicacion::findOrFail($id);
            $publicacion->update(['estado' => 'Oculta']);
            return back()->with('exito', 'Publicación ocultada correctamente.');
        }

        if ($tipo === 'reporte') {
            $reporte = Reporte::findOrFail($id);
            $reporte->update(['estado' => 'Cancelado']);
            return back()->with('exito', 'Reporte cancelado y ocultado.');
        }

        return back()->withErrors(['error' => 'Tipo no válido.']);
    }

    public function mostrar($tipo, $id)
    {
        if ($tipo === 'publicacion') {
            $publicacion = Publicacion::findOrFail($id);
            $publicacion->update(['estado' => 'Visible']);
            return back()->with('exito', 'Publicación visible nuevamente en la comunidad.');
        }

        if ($tipo === 'reporte') {
            $reporte = Reporte::findOrFail($id);
            $reporte->update(['estado' => 'Activo']);
            return back()->with('exito', 'Reporte activado nuevamente.');
        }

        return back()->withErrors(['error' => 'Tipo no válido.']);
    }
}
