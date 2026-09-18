<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Reporte;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PetRescueController extends Controller
{
    public function bienvenida(): View
    {
        return view('bienvenida');
    }

    public function inicio(): View
    {
        $reportes = Reporte::with('mascota')
            ->orderByDesc('fecha_publicacion')
            ->take(12)
            ->get()
            ->map(function (Reporte $reporte) {
                $mascota = $reporte->mascota;
                $fotografia = $mascota && $mascota->fotografia
                    ? asset('storage/' . $mascota->fotografia)
                    : 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=600';

                return [
                    'id' => $reporte->id,
                    'nombre' => $mascota && $mascota->nombre
                        ? $mascota->nombre
                        : 'Mascota sin nombre',
                    'tipo' => $mascota && $mascota->tipo
                        ? $mascota->tipo
                        : 'Otro',
                    'ubicacion' => trim(
                        ($reporte->barrio ?? '') .
                        ', ' .
                        ($reporte->ciudad ?? ''),
                        ', '
                    ),
                    'fecha' => $reporte->fecha_suceso
                        ? $reporte->fecha_suceso->format('d/m/Y')
                        : '',
                    'estado' => $reporte->tipo_reporte === 'Perdida'
                        ? 'Perdida'
                        : 'Encontrada',
                    'imagen' => $fotografia,
                ];
            })
            ->toArray();

        return view('inicio', compact('reportes'));
    }

    public function crearReportePerdida(): View
    {
        return view('reportes.perdida');
    }

    public function guardarReportePerdida(Request $request): RedirectResponse
    {
        $datos = $request->validate(
            [
                'nombre_mascota' => ['required', 'string', 'max:100'],
                'tipo' => ['required', 'in:Perro,Gato,Otro'],
                'raza' => ['nullable', 'string', 'max:100'],
                'color' => ['required', 'string', 'max:100'],
                'tamano' => ['required', 'in:Pequeno,Mediano,Grande'],
                'sexo' => ['nullable', 'in:Macho,Hembra,Desconocido'],
                'edad_aproximada' => ['nullable', 'string', 'max:50'],
                'identificacion' => ['nullable', 'string', 'max:150'],
                'fotografia' => ['nullable', 'image', 'max:4096'],
                'caracteristicas' => ['required', 'string'],
                'fecha_perdida' => ['required', 'date'],
                'hora_perdida' => ['nullable'],
                'ciudad' => ['required', 'string', 'max:100'],
                'barrio' => ['required', 'string', 'max:150'],
                'referencia' => ['required', 'string', 'max:255'],
                'descripcion' => ['required', 'string'],
                'confirmar_informacion' => ['accepted'],
            ],
            [
                'nombre_mascota.required' => 'El nombre de la mascota es obligatorio.',
                'tipo.required' => 'Debes seleccionar el tipo de mascota.',
                'color.required' => 'El color principal es obligatorio.',
                'tamano.required' => 'Debes seleccionar el tamaño.',
                'fotografia.image' => 'La fotografía debe ser una imagen válida.',
                'fotografia.max' => 'La fotografía no puede superar los 4 MB.',
                'caracteristicas.required' => 'Debes describir las características particulares.',
                'fecha_perdida.required' => 'La fecha de pérdida es obligatoria.',
                'ciudad.required' => 'La ciudad es obligatoria.',
                'barrio.required' => 'El barrio es obligatorio.',
                'referencia.required' => 'La dirección o referencia es obligatoria.',
                'descripcion.required' => 'Debes describir las circunstancias de la pérdida.',
                'confirmar_informacion.accepted' => 'Debes confirmar que la información es correcta.',
            ]
        );

        $rutaFotografia = null;

        if ($request->hasFile('fotografia')) {
            $rutaFotografia = $request
                ->file('fotografia')
                ->store('mascotas', 'public');
        }

        $mascota = Mascota::create([
            'propietario_id' => Auth::id(),
            'nombre' => $datos['nombre_mascota'],
            'tipo' => $datos['tipo'],
            'raza' => $datos['raza'] ?? null,
            'color_principal' => $datos['color'],
            'color_secundario' => null,
            'tamano' => $datos['tamano'],
            'sexo' => $datos['sexo'] ?? 'Desconocido',
            'edad_aproximada' => $datos['edad_aproximada'] ?? null,
            'caracteristicas_particulares' => $datos['caracteristicas'],
            'identificacion' => $datos['identificacion'] ?? null,
            'fotografia' => $rutaFotografia,
        ]);

        Reporte::create([
            'mascota_id' => $mascota->id,
            'usuario_reportante_id' => Auth::id(),
            'tipo_reporte' => 'Perdida',
            'fecha_suceso' => $datos['fecha_perdida'],
            'hora_aproximada' => $datos['hora_perdida'] ?? null,
            'ciudad' => $datos['ciudad'],
            'barrio' => $datos['barrio'],
            'direccion_referencia' => $datos['referencia'],
            'descripcion' => $datos['descripcion'],
            'ubicacion_actual' => null,
            'estado_fisico' => null,
            'estado' => 'Activo',
            'fecha_publicacion' => now(),
        ]);

        return redirect()
            ->route('inicio')
            ->with('exito', 'El reporte de mascota perdida fue registrado correctamente.');
    }

    public function crearReporteHallazgo(): View
    {
        return view('reportes.hallazgo');
    }

    public function guardarReporteHallazgo(Request $request): RedirectResponse
    {
        $datos = $request->validate(
            [
                'tipo' => ['required', 'in:Perro,Gato,Otro'],
                'raza' => ['nullable', 'string', 'max:100'],
                'color' => ['required', 'string', 'max:100'],
                'tamano' => ['required', 'in:Pequeno,Mediano,Grande'],
                'sexo' => ['nullable', 'in:Macho,Hembra,No identificado'],
                'edad_aproximada' => ['nullable', 'string', 'max:50'],
                'estado_fisico' => ['required', 'in:Bueno,Herido,Requiere atencion,No identificado'],
                'fotografia' => ['required', 'image', 'max:4096'],
                'caracteristicas' => ['required', 'string'],
                'fecha_hallazgo' => ['required', 'date'],
                'hora_hallazgo' => ['nullable'],
                'ciudad' => ['required', 'string', 'max:100'],
                'barrio' => ['required', 'string', 'max:150'],
                'referencia' => ['required', 'string', 'max:255'],
                'ubicacion_actual' => ['required', 'string', 'max:255'],
                'circunstancias' => ['required', 'string'],
                'confirmar_informacion' => ['accepted'],
            ],
            [
                'tipo.required' => 'Debes seleccionar el tipo de mascota.',
                'color.required' => 'El color principal es obligatorio.',
                'tamano.required' => 'Debes seleccionar el tamaño.',
                'estado_fisico.required' => 'Debes indicar el estado físico.',
                'fotografia.required' => 'La fotografía es obligatoria para un hallazgo.',
                'fotografia.image' => 'La fotografía debe ser una imagen válida.',
                'caracteristicas.required' => 'Debes describir las características particulares.',
                'fecha_hallazgo.required' => 'La fecha del hallazgo es obligatoria.',
                'ciudad.required' => 'La ciudad es obligatoria.',
                'barrio.required' => 'El barrio es obligatorio.',
                'referencia.required' => 'La dirección o referencia es obligatoria.',
                'ubicacion_actual.required' => 'Debes indicar dónde se encuentra la mascota.',
                'circunstancias.required' => 'Debes describir las circunstancias del hallazgo.',
                'confirmar_informacion.accepted' => 'Debes confirmar que la información es correcta.',
            ]
        );

        $rutaFotografia = null;

        if ($request->hasFile('fotografia')) {
            $rutaFotografia = $request
                ->file('fotografia')
                ->store('mascotas', 'public');
        }

        $mascota = Mascota::create([
            'propietario_id' => null,
            'nombre' => 'Mascota encontrada',
            'tipo' => $datos['tipo'],
            'raza' => $datos['raza'] ?? null,
            'color_principal' => $datos['color'],
            'color_secundario' => null,
            'tamano' => $datos['tamano'],
            'sexo' => $datos['sexo'] ?? 'Desconocido',
            'edad_aproximada' => $datos['edad_aproximada'] ?? null,
            'caracteristicas_particulares' => $datos['caracteristicas'],
            'identificacion' => null,
            'fotografia' => $rutaFotografia,
        ]);

        Reporte::create([
            'mascota_id' => $mascota->id,
            'usuario_reportante_id' => Auth::id(),
            'tipo_reporte' => 'Hallazgo',
            'fecha_suceso' => $datos['fecha_hallazgo'],
            'hora_aproximada' => $datos['hora_hallazgo'] ?? null,
            'ciudad' => $datos['ciudad'],
            'barrio' => $datos['barrio'],
            'direccion_referencia' => $datos['referencia'],
            'descripcion' => $datos['circunstancias'],
            'ubicacion_actual' => $datos['ubicacion_actual'],
            'estado_fisico' => $datos['estado_fisico'],
            'estado' => 'Activo',
            'fecha_publicacion' => now(),
        ]);

        return redirect()
            ->route('inicio')
            ->with('exito', 'El reporte de mascota encontrada fue registrado correctamente.');
    }

    public function perfil(): View
    {
        return view('perfil');
    }

    public function actualizarContacto(Request $request): RedirectResponse
    {
        return redirect()
            ->route('perfil')
            ->with('exito', 'La información de contacto fue actualizada correctamente.');
    }
}
