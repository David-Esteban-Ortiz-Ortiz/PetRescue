<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicacionController extends Controller
{
    public function index(): View
    {
        return view('comunidad.index', [
            'publicaciones' => [],
        ]);
    }

    public function crear(): View
    {
        return view('comunidad.crear');
    }

    public function guardar(Request $request): RedirectResponse
    {
        return redirect()
            ->route('comunidad.index')
            ->with('exito', 'Publicación registrada (stub pendiente de implementación).');
    }

    public function detalle(string $codigoPublicacion): View
    {
        return view('comunidad.detalle', [
            'codigoPublicacion' => $codigoPublicacion,
        ]);
    }
}
