<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class PublicacionController extends Controller
{
    public function index(): View
    {
        $publicaciones = Publicacion::where('estado', 'Visible')
            ->orderByDesc('fecha_publicacion')
            ->take(20)
            ->get();

        return view('comunidad.index', compact('publicaciones'));
    }

    public function crear(): View
    {
        return view('comunidad.crear');
    }

    public function guardar(Request $request): RedirectResponse
    {
        // 1. Validación
        $datos = $request->validate([
            'nombre_autor'     => ['required', 'string', 'max:150'],
            'titulo'           => ['required', 'string', 'max:150'],
            'tipo_publicacion' => ['required', Rule::in(Publicacion::TIPOS)],
            'contenido'        => ['required', 'string'],
            'fotografia'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'nombre_autor.required'     => 'El nombre del autor es obligatorio.',
            'nombre_autor.max'          => 'El nombre del autor no puede superar 150 caracteres.',
            'titulo.required'           => 'El título es obligatorio.',
            'titulo.max'                => 'El título no puede superar 150 caracteres.',
            'tipo_publicacion.required' => 'Debes seleccionar un tipo de publicación.',
            'tipo_publicacion.in'       => 'El tipo de publicación seleccionado no es válido.',
            'contenido.required'        => 'El contenido es obligatorio.',
            'fotografia.image'          => 'La fotografía debe ser una imagen válida.',
            'fotografia.mimes'          => 'La fotografía debe ser JPG, JPEG, PNG o WEBP.',
            'fotografia.max'            => 'La fotografía no puede superar los 4 MB.',
        ]);

        // 2. Guardar fotografía (ruta relativa, ej: publicaciones/abc123.jpg)
        $rutaFotografia = null;

        if ($request->hasFile('fotografia')) {
            $rutaFotografia = $request->file('fotografia')->store('publicaciones', 'public');
        }

        try {
            DB::beginTransaction();

            // 3. Código único PUB-XXXXXXXX
            do {
                $codigo = 'PUB-' . strtoupper(Str::random(8));
            } while (Publicacion::where('codigo_publicacion', $codigo)->exists());

            // 4. Crear el registro
            Publicacion::create([
                'codigo_publicacion' => $codigo,
                'nombre_autor'       => $datos['nombre_autor'],
                'titulo'             => $datos['titulo'],
                'tipo_publicacion'   => $datos['tipo_publicacion'],
                'contenido'          => $datos['contenido'],
                'fotografia'         => $rutaFotografia,
                'estado'             => 'Visible',
                'fecha_publicacion'  => now(),
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            // Si falla la BD, se borra la foto que ya se había subido
            if ($rutaFotografia) {
                Storage::disk('public')->delete($rutaFotografia);
            }

            throw $e;
        }

        // 5. Redirigir al detalle
        return redirect()
            ->route('comunidad.detalle', $codigo)
            ->with('exito', 'Publicación creada correctamente.');
    }

    public function detalle(string $codigoPublicacion): View|RedirectResponse
    {
        $publicacion = Publicacion::where('codigo_publicacion', $codigoPublicacion)->first();

        if (! $publicacion) {
            return redirect()
                ->route('comunidad.index')
                ->withErrors(['publicacion' => 'La publicación solicitada no existe.']);
        }

        return view('comunidad.detalle', compact('publicacion', 'codigoPublicacion'));
    }
}