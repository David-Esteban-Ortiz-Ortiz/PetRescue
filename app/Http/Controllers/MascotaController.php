<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use Illuminate\Support\Facades\Storage;

class MascotaController extends Controller
{
    // 1. Listar las mascotas del usuario
    public function index()
    {
        $mascotas = Mascota::where('propietario_id', auth()->id())->get();
        return view('mascotas.index', compact('mascotas'));
    }

    // 2. Mostrar el formulario de creación
    public function crear()
    {
        return view('mascotas.crear');
    }

    // 3. Guardar una nueva mascota
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:Perro,Gato,Otro',
            'raza' => 'nullable|string|max:100',
            'color_principal' => 'required|string|max:100',
            'tamano' => 'required|in:Pequeno,Mediano,Grande',
            'caracteristicas_particulares' => 'required|string',
            'fotografia' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $rutaFotografia = null;
        if ($request->hasFile('fotografia')) {
            $rutaFotografia = $request->file('fotografia')->store('mascotas', 'public');
        }

        Mascota::create([
            'propietario_id' => auth()->id(),
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'raza' => $request->raza,
            'color_principal' => $request->color_principal,
            'tamano' => $request->tamano,
            'caracteristicas_particulares' => $request->caracteristicas_particulares,
            'fotografia' => $rutaFotografia,
        ]);

        return redirect()->route('mascotas.index')->with('exito', '¡Mascota registrada exitosamente!');
    }

    // 4. Mostrar el formulario de edición
    public function editar($id)
    {
        $mascota = Mascota::where('id', $id)->where('propietario_id', auth()->id())->firstOrFail();
        return view('mascotas.editar', compact('mascota'));
    }

    // 5. Actualizar la mascota en la base de datos
    public function actualizar(Request $request, $id)
    {
        $mascota = Mascota::where('id', $id)->where('propietario_id', auth()->id())->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:Perro,Gato,Otro',
            'raza' => 'nullable|string|max:100',
            'color_principal' => 'required|string|max:100',
            'tamano' => 'required|in:Pequeno,Mediano,Grande',
            'caracteristicas_particulares' => 'required|string',
            'fotografia' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $datos = $request->except(['fotografia', '_token', '_method']);

        if ($request->hasFile('fotografia')) {
            // Borrar foto anterior si existe
            if ($mascota->fotografia) {
                Storage::disk('public')->delete($mascota->fotografia);
            }
            $datos['fotografia'] = $request->file('fotografia')->store('mascotas', 'public');
        }

        $mascota->update($datos);

        return redirect()->route('mascotas.index')->with('exito', '¡Mascota actualizada exitosamente!');
    }
}
