<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Models\Reporte;
use App\Models\Comentario;

class AdminController extends Controller
{
    public function dashboard()
    {
        $reportes = Reporte::orderBy('id', 'desc')->get();
        $publicaciones = Publicacion::orderBy('id', 'desc')->get();

        return view('admin.dashboard', compact('reportes', 'publicaciones'));
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

            return back()->with('exito', 'Reporte cancelado y ocultado de la comunidad.');
        }

        if ($tipo === 'comentario') {
            $comentario = Comentario::findOrFail($id);
            $comentario->delete();

            return back()->with('exito', 'Comentario eliminado correctamente.');
        }

        return back()->withErrors(['error' => 'Tipo no válido.']);
    }
}
