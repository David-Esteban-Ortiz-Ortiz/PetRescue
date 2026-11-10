<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Publicacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class PublicacionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Publicacion::where('estado', 'Visible');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', '%' . $buscar . '%')
                    ->orWhere('contenido', 'like', '%' . $buscar . '%')
                    ->orWhere('nombre_autor', 'like', '%' . $buscar . '%');
            });
        }

        $tipo = $request->input('tipo_publicacion', $request->input('tipo'));

        if (filled($tipo)) {
            $query->where('tipo_publicacion', $tipo);
        }

        $publicaciones = $query->orderByDesc('fecha_publicacion')->get();

        return view('comunidad.index', compact('publicaciones'));
    }

    public function crear(): View
    {
        return view('comunidad.crear');
    }

    public function guardar(Request $request): RedirectResponse
    {
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

        $rutaFotografia = null;

        if ($request->hasFile('fotografia')) {
            $rutaFotografia = $request->file('fotografia')->store('publicaciones', 'public');
        }

        try {
            DB::beginTransaction();

            // Creamos el registro y lo guardamos en una variable para obtener su ID
            $publicacion = Publicacion::create([
                'user_id'            => auth()->id(), // <-- GUARDAMOS EL DUEÑO
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

            if ($rutaFotografia) {
                Storage::disk('public')->delete($rutaFotografia);
            }

            throw $e;
        }

        // Redirigimos usando el ID de la publicación recién creada
        return redirect()
            ->route('comunidad.detalle', $publicacion->id)
            ->with('exito', 'Publicación creada correctamente.');
    }

    public function detalle($id): View|RedirectResponse
    {
        $publicacion = Publicacion::with('comentarios.user')->find($id);

        if (!$publicacion) {
            return redirect()->route('comunidad.index')->withErrors(['error' => 'La publicación no existe.']);
        }

        return view('comunidad.detalle', compact('publicacion'));
    }

    public function eliminar($id): RedirectResponse
    {
        $publicacion = Publicacion::findOrFail($id);

        // Verificar que el usuario actual sea el dueño
        if (auth()->id() !== $publicacion->user_id) {
            return back()->withErrors(['error' => 'No tienes permiso para eliminar esta publicación.']);
        }

        // Borrar la foto del almacenamiento si existe
        if ($publicacion->fotografia) {
            Storage::disk('public')->delete($publicacion->fotografia);
        }

        $publicacion->delete();

        return redirect()->route('comunidad.index')->with('exito', 'Publicación eliminada correctamente.');
    }

    public function guardarComentario(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'contenido' => ['required', 'string', 'max:500'],
        ], [
            'contenido.required' => 'El comentario no puede estar vacío.',
            'contenido.max'      => 'El comentario no puede superar 500 caracteres.',
        ]);

        Comentario::create([
            'publicacion_id' => $id,
            'user_id'        => auth()->id(), // <-- GUARDAMOS EL DUEÑO DEL COMENTARIO
            'nombre_autor'   => auth()->check() ? auth()->user()->name : 'Anónimo',
            'contenido'      => $request->input('contenido'),
        ]);

        return back()->with('exito', '¡Comentario publicado!');
    }
}
