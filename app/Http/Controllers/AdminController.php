<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Juliana llenará esto después
        return view('admin.dashboard');
    }

    public function ocultar($tipo, $id)
    {
        // Juliana llenará esto después
        return back()->with('exito', 'Elemento ocultado correctamente (Simulado).');
    }
}
