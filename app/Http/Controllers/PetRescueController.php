<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Mascota;
use App\Models\Reporte;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PetRescueController extends Controller
{
    public function bienvenida(): View
    {
        return view('bienvenida');
    }

    public function inicio(Request $request): View
    {
        $query = Reporte::with('mascota')->where('estado', 'Activo');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('barrio', 'like', '%' . $buscar . '%')
                  ->orWhere('ciudad', 'like', '%' . $buscar . '%')
                  ->orWhereHas('mascota', function ($mQuery) use ($buscar) {
                      $mQuery->where('nombre', 'like', '%' . $buscar . '%');
                  });
            });
        }

        if ($request->filled('tipo')) {
            $query->whereHas('mascota', function ($mQuery) use ($request) {
                $mQuery->where('tipo', $request->input('tipo'));
            });
        }

        $reportes = $query->orderByDesc('fecha_publicacion')->get()->map(function (Reporte $reporte) {
            $mascota = $reporte->mascota;
            $fotografia = $mascota && $mascota->fotografia ? asset('storage/' . $mascota->fotografia) : 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=600';

            return [
                'id' => $reporte->id,
                'nombre' => $mascota && $mascota->nombre ? $mascota->nombre : 'Mascota sin nombre',
                'tipo' => $mascota && $mascota->tipo ? $mascota->tipo : 'Otro',
                'ubicacion' => trim(($reporte->barrio ?? '') . ', ' . ($reporte->ciudad ?? ''), ', '),
                'fecha' => $reporte->fecha_suceso ? $reporte->fecha_suceso->format('d/m/Y') : '',
                'estado' => $reporte->tipo_reporte === 'Perdida' ? 'Perdida' : 'Encontrada',
                'imagen' => $fotografia,
            ];
        })->toArray();

        return view('inicio', compact('reportes'));
    }

    public function crearReportePerdida(): View
    {
        return view('reportes.perdida');
    }

    public function guardarReportePerdida(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'mascota_id' => ['required', 'exists:mascotas,id'],
            'fecha_suceso' => ['required', 'date'],
            'hora_aproximada' => ['nullable'],
            'ciudad' => ['required', 'string', 'max:100'],
            'barrio' => ['required', 'string', 'max:150'],
            'direccion_referencia' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'nombre_contacto' => ['required', 'string', 'max:150'],
            'telefono_contacto' => ['required', 'string', 'min:7', 'max:20'],
            'correo_contacto' => ['nullable', 'email', 'max:150'],
            'medio_contacto_preferido' => ['required', 'in:Telefono,WhatsApp,Correo'],
            'confirmar_informacion' => ['accepted'],
        ], [
            'mascota_id.required' => 'Debes seleccionar una mascota.',
            'fecha_suceso.required' => 'La fecha de pérdida es obligatoria.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'barrio.required' => 'El barrio es obligatorio.',
            'direccion_referencia.required' => 'La dirección o referencia es obligatoria.',
            'descripcion.required' => 'Debes describir las circunstancias de la pérdida.',
            'nombre_contacto.required' => 'El nombre de contacto es obligatorio.',
            'telefono_contacto.required' => 'El teléfono de contacto es obligatorio.',
            'telefono_contacto.min' => 'El teléfono debe tener al menos 7 caracteres.',
            'correo_contacto.email' => 'El correo de contacto debe ser válido.',
            'medio_contacto_preferido.required' => 'Debes indicar el medio de contacto preferido.',
            'confirmar_informacion.accepted' => 'Debes confirmar que la información es correcta.',
        ]);

        $mascota = Mascota::where('id', $datos['mascota_id'])->where('propietario_id', auth()->id())->firstOrFail();

        Reporte::create([
            'mascota_id' => $mascota->id,
            'usuario_reportante_id' => auth()->id(),
            'nombre_contacto' => $datos['nombre_contacto'],
            'telefono_contacto' => $datos['telefono_contacto'],
            'correo_contacto' => $datos['correo_contacto'] ?? null,
            'medio_contacto_preferido' => $datos['medio_contacto_preferido'],
            'tipo_reporte' => 'Perdida',
            'fecha_suceso' => $datos['fecha_suceso'],
            'hora_aproximada' => $datos['hora_aproximada'] ?? null,
            'ciudad' => $datos['ciudad'],
            'barrio' => $datos['barrio'],
            'direccion_referencia' => $datos['direccion_referencia'],
            'descripcion' => $datos['descripcion'],
            'estado' => 'Activo',
            'fecha_publicacion' => now(),
        ]);

        return redirect()->route('inicio')->with('exito', '¡El reporte de mascota perdida fue publicado exitosamente!');
    }

    public function crearReporteHallazgo(): View
    {
        return view('reportes.hallazgo');
    }

    public function guardarReporteHallazgo(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'tipo' => ['required', 'in:Perro,Gato,Otro'],
            'raza' => ['nullable', 'string', 'max:100'],
            'color_principal' => ['required', 'string', 'max:100'],
            'color_secundario' => ['nullable', 'string', 'max:100'],
            'tamano' => ['required', 'in:Pequeno,Mediano,Grande'],
            'sexo' => ['nullable', 'in:Macho,Hembra,No identificado'],
            'edad_aproximada' => ['nullable', 'string', 'max:50'],
            'caracteristicas_particulares' => ['required', 'string'],
            'fotografia' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'fecha_suceso' => ['required', 'date'],
            'hora_aproximada' => ['nullable'],
            'ciudad' => ['required', 'string', 'max:100'],
            'barrio' => ['required', 'string', 'max:150'],
            'direccion_referencia' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'ubicacion_actual' => ['required', 'string', 'max:255'],
            'estado_fisico' => ['required', 'in:Bueno,Herido,Requiere atencion,No identificado'],
            'nombre_contacto' => ['required', 'string', 'max:150'],
            'telefono_contacto' => ['required', 'string', 'min:7', 'max:20'],
            'correo_contacto' => ['nullable', 'email', 'max:150'],
            'medio_contacto_preferido' => ['required', 'in:Telefono,WhatsApp,Correo'],
            'confirmar_informacion' => ['accepted'],
        ], [
            'tipo.required' => 'Debes seleccionar el tipo de mascota.',
            'color_principal.required' => 'El color principal es obligatorio.',
            'tamano.required' => 'Debes seleccionar el tamaño.',
            'caracteristicas_particulares.required' => 'Debes describir las características particulares.',
            'fotografia.required' => 'La fotografía es obligatoria para un hallazgo.',
            'fotografia.image' => 'La fotografía debe ser una imagen válida.',
            'fotografia.mimes' => 'La fotografía debe ser JPG, JPEG, PNG o WEBP.',
            'fotografia.max' => 'La fotografía no puede superar los 4 MB.',
            'fecha_suceso.required' => 'La fecha del hallazgo es obligatoria.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'barrio.required' => 'El barrio es obligatorio.',
            'direccion_referencia.required' => 'La dirección o referencia es obligatoria.',
            'descripcion.required' => 'Debes describir las circunstancias del hallazgo.',
            'ubicacion_actual.required' => 'Debes indicar dónde se encuentra la mascota.',
            'estado_fisico.required' => 'Debes indicar el estado físico.',
            'nombre_contacto.required' => 'El nombre de contacto es obligatorio.',
            'telefono_contacto.required' => 'El teléfono de contacto es obligatorio.',
            'correo_contacto.email' => 'El correo de contacto debe ser válido.',
            'medio_contacto_preferido.required' => 'Debes indicar el medio de contacto preferido.',
            'confirmar_informacion.accepted' => 'Debes confirmar que la información es correcta.',
        ]);

        $rutaFotografia = $request->hasFile('fotografia') ? $request->file('fotografia')->store('reportes', 'public') : null;

        $mascota = Mascota::create([
            'propietario_id' => null,
            'nombre' => 'Mascota encontrada',
            'tipo' => $datos['tipo'],
            'raza' => $datos['raza'] ?? null,
            'color_principal' => $datos['color_principal'],
            'color_secundario' => $datos['color_secundario'] ?? null,
            'tamano' => $datos['tamano'],
            'sexo' => $datos['sexo'] ?? 'Desconocido',
            'edad_aproximada' => $datos['edad_aproximada'] ?? null,
            'caracteristicas_particulares' => $datos['caracteristicas_particulares'],
            'fotografia' => $rutaFotografia,
        ]);

        Reporte::create([
            'mascota_id' => $mascota->id,
            'usuario_reportante_id' => auth()->id(),
            'nombre_contacto' => $datos['nombre_contacto'],
            'telefono_contacto' => $datos['telefono_contacto'],
            'correo_contacto' => $datos['correo_contacto'] ?? null,
            'medio_contacto_preferido' => $datos['medio_contacto_preferido'],
            'tipo_reporte' => 'Hallazgo',
            'fecha_suceso' => $datos['fecha_suceso'],
            'hora_aproximada' => $datos['hora_aproximada'] ?? null,
            'ciudad' => $datos['ciudad'],
            'barrio' => $datos['barrio'],
            'direccion_referencia' => $datos['direccion_referencia'],
            'descripcion' => $datos['descripcion'],
            'ubicacion_actual' => $datos['ubicacion_actual'],
            'estado_fisico' => $datos['estado_fisico'],
            'estado' => 'Activo',
            'fecha_publicacion' => now(),
        ]);

        return redirect()->route('inicio')->with('exito', '¡El reporte de mascota encontrada fue publicado exitosamente!');
    }

    public function mostrarReporte($id): View|RedirectResponse
    {
        $reporte = Reporte::with('mascota')->find($id);

        if (!$reporte) {
            return redirect()->route('inicio')->withErrors(['reporte' => 'El reporte solicitado no existe.']);
        }

        return view('reportes.detalle', compact('reporte'));
    }

    public function guardarComentario(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'contenido' => ['required', 'string', 'max:500'],
        ], [
            'contenido.required' => 'El comentario no puede estar vacío.',
            'contenido.max' => 'El comentario no puede superar 500 caracteres.',
        ]);

        Comentario::create([
            'reporte_id' => $id,
            'user_id' => auth()->id(),
            'nombre_autor' => auth()->user()->name,
            'contenido' => $request->input('contenido'),
        ]);

        return back()->with('exito', 'Comentario añadido correctamente.');
    }

    public function resolverReporte($id)
    {
        $reporte = Reporte::findOrFail($id);

        if (auth()->id() != $reporte->usuario_reportante_id) {
            return back()->withErrors(['error' => 'No tienes permiso para resolver este reporte.']);
        }

        $reporte->update([
            'estado' => 'Resuelto',
            'fecha_cierre' => now()
        ]);

        return back()->with('exito', '¡Felicidades! El reporte ha sido marcado como resuelto y la comunidad ha sido notificada.');
    }
}
