<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Reporte;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

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
                    'codigo_reporte' => $reporte->codigo_reporte,
                    'nombre' => $mascota && $mascota->nombre
                        ? $mascota->nombre
                        : 'Mascota sin nombre',
                    'tipo' => $mascota && $mascota->tipo
                        ? $mascota->tipo
                        : 'Otro',
                    'ubicacion' => trim(
                        ($reporte->barrio ?? '') . ', ' . ($reporte->ciudad ?? ''),
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
                'color_principal' => ['required', 'string', 'max:100'],
                'color_secundario' => ['nullable', 'string', 'max:100'],
                'tamano' => ['required', 'in:Pequeno,Mediano,Grande'],
                'sexo' => ['nullable', 'in:Macho,Hembra,Desconocido'],
                'edad_aproximada' => ['nullable', 'string', 'max:50'],
                'identificacion' => ['nullable', 'string', 'max:150'],
                'caracteristicas_particulares' => ['required', 'string'],
                'fotografia' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
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
            ],
            [
                'nombre_mascota.required' => 'El nombre de la mascota es obligatorio.',
                'tipo.required' => 'Debes seleccionar el tipo de mascota.',
                'color_principal.required' => 'El color principal es obligatorio.',
                'tamano.required' => 'Debes seleccionar el tamaño.',
                'caracteristicas_particulares.required' => 'Debes describir las características particulares.',
                'fotografia.image' => 'La fotografía debe ser una imagen válida.',
                'fotografia.mimes' => 'La fotografía debe ser JPG, JPEG, PNG o WEBP.',
                'fotografia.max' => 'La fotografía no puede superar los 4 MB.',
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
            ]
        );

        $rutaFotografia = null;

        if ($request->hasFile('fotografia')) {
            $rutaFotografia = $request->file('fotografia')->store('reportes', 'public');
        }

        [$reporte, $codigoEdicionPlano] = $this->crearMascotaYReporte(
            $datos,
            $rutaFotografia,
            'Perdida',
            null,
            null
        );

        return redirect()
            ->route('reportes.confirmacion')
            ->with('codigo_reporte_nuevo', $reporte->codigo_reporte)
            ->with('codigo_edicion_nuevo', $codigoEdicionPlano)
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
            ],
            [
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
            ]
        );

        $rutaFotografia = null;

        if ($request->hasFile('fotografia')) {
            $rutaFotografia = $request->file('fotografia')->store('reportes', 'public');
        }

        [$reporte, $codigoEdicionPlano] = $this->crearMascotaYReporte(
            $datos,
            $rutaFotografia,
            'Hallazgo',
            $datos['ubicacion_actual'],
            $datos['estado_fisico']
        );

        return redirect()
            ->route('reportes.confirmacion')
            ->with('codigo_reporte_nuevo', $reporte->codigo_reporte)
            ->with('codigo_edicion_nuevo', $codigoEdicionPlano)
            ->with('exito', 'El reporte de mascota encontrada fue registrado correctamente.');
    }

    public function mostrarConfirmacion(): View|RedirectResponse
    {
        $codigoReporte = session('codigo_reporte_nuevo');
        $codigoEdicion = session('codigo_edicion_nuevo');

        if (!$codigoReporte || !$codigoEdicion) {
            return redirect()->route('inicio');
        }

        return view('reportes.confirmacion', compact('codigoReporte', 'codigoEdicion'));
    }

    public function mostrarFormularioActualizarContacto(): View
    {
        return view('reportes.actualizar-contacto');
    }

    public function verificarCodigos(Request $request): View|RedirectResponse
    {
        $datos = $request->validate(
            [
                'codigo_reporte' => ['required', 'string', 'max:30'],
                'codigo_edicion' => ['required', 'string', 'max:100'],
            ],
            [
                'codigo_reporte.required' => 'Debes ingresar el código del reporte.',
                'codigo_edicion.required' => 'Debes ingresar el código de edición.',
            ]
        );

        $reporte = Reporte::where('codigo_reporte', $datos['codigo_reporte'])->first();

        if (!$reporte || !$reporte->codigo_edicion || !Hash::check($datos['codigo_edicion'], $reporte->codigo_edicion)) {
            return redirect()
                ->route('reportes.actualizar-contacto')
                ->withErrors(['codigos' => 'Los datos ingresados no son válidos.'])
                ->onlyInput('codigo_reporte');
        }

        return view('reportes.editar-contacto', [
            'reporte' => $reporte,
            'codigoEdicion' => $datos['codigo_edicion'],
        ]);
    }

    public function actualizarContacto(Request $request, string $codigoReporte): RedirectResponse
    {
        $datos = $request->validate(
            [
                'codigo_edicion' => ['required', 'string', 'max:100'],
                'nombre_contacto' => ['required', 'string', 'max:150'],
                'telefono_contacto' => ['required', 'string', 'min:7', 'max:20'],
                'correo_contacto' => ['nullable', 'email', 'max:150'],
                'medio_contacto_preferido' => ['required', 'in:Telefono,WhatsApp,Correo'],
            ],
            [
                'nombre_contacto.required' => 'El nombre de contacto es obligatorio.',
                'telefono_contacto.required' => 'El teléfono de contacto es obligatorio.',
                'telefono_contacto.min' => 'El teléfono debe tener al menos 7 caracteres.',
                'correo_contacto.email' => 'El correo de contacto debe ser válido.',
                'medio_contacto_preferido.required' => 'Debes indicar el medio de contacto preferido.',
            ]
        );

        $reporte = Reporte::where('codigo_reporte', $codigoReporte)->first();

        if (!$reporte || !$reporte->codigo_edicion || !Hash::check($datos['codigo_edicion'], $reporte->codigo_edicion)) {
            return redirect()
                ->route('reportes.actualizar-contacto')
                ->withErrors(['codigos' => 'Los datos ingresados no son válidos.']);
        }

        $reporte->update([
            'nombre_contacto' => $datos['nombre_contacto'],
            'telefono_contacto' => $datos['telefono_contacto'],
            'correo_contacto' => $datos['correo_contacto'] ?? null,
            'medio_contacto_preferido' => $datos['medio_contacto_preferido'],
        ]);

        return redirect()
            ->route('inicio')
            ->with('exito', 'La información de contacto fue actualizada correctamente.');
    }

    public function mostrarReporte(string $codigoReporte): View|RedirectResponse
    {
        $reporte = Reporte::with('mascota')
            ->where('codigo_reporte', $codigoReporte)
            ->first();

        if (!$reporte) {
            return redirect()
                ->route('inicio')
                ->withErrors(['reporte' => 'El reporte solicitado no existe.']);
        }

        return view('reportes.detalle', compact('reporte'));
    }

    private function crearMascotaYReporte(
        array $datos,
        ?string $rutaFotografia,
        string $tipoReporte,
        ?string $ubicacionActual,
        ?string $estadoFisico
    ): array {
        $codigoEdicionPlano = Str::upper(Str::random(16));

        try {
            $resultado = DB::transaction(function () use (
                $datos,
                $rutaFotografia,
                $tipoReporte,
                $ubicacionActual,
                $estadoFisico,
                $codigoEdicionPlano
            ) {
                $mascota = Mascota::create([
                    'propietario_id' => null,
                    'nombre' => $datos['nombre_mascota'] ?? 'Mascota encontrada',
                    'tipo' => $datos['tipo'],
                    'raza' => $datos['raza'] ?? null,
                    'color_principal' => $datos['color_principal'],
                    'color_secundario' => $datos['color_secundario'] ?? null,
                    'tamano' => $datos['tamano'],
                    'sexo' => $datos['sexo'] ?? 'Desconocido',
                    'edad_aproximada' => $datos['edad_aproximada'] ?? null,
                    'caracteristicas_particulares' => $datos['caracteristicas_particulares'],
                    'identificacion' => $datos['identificacion'] ?? null,
                    'fotografia' => $rutaFotografia,
                ]);

                $codigoReporte = $this->generarCodigoReporteUnico();

                $reporte = Reporte::create([
                    'mascota_id' => $mascota->id,
                    'usuario_reportante_id' => null,
                    'nombre_contacto' => $datos['nombre_contacto'],
                    'telefono_contacto' => $datos['telefono_contacto'],
                    'correo_contacto' => $datos['correo_contacto'] ?? null,
                    'medio_contacto_preferido' => $datos['medio_contacto_preferido'],
                    'codigo_reporte' => $codigoReporte,
                    'codigo_edicion' => Hash::make($codigoEdicionPlano),
                    'tipo_reporte' => $tipoReporte,
                    'fecha_suceso' => $datos['fecha_suceso'],
                    'hora_aproximada' => $datos['hora_aproximada'] ?? null,
                    'ciudad' => $datos['ciudad'],
                    'barrio' => $datos['barrio'],
                    'direccion_referencia' => $datos['direccion_referencia'],
                    'descripcion' => $datos['descripcion'],
                    'ubicacion_actual' => $ubicacionActual,
                    'estado_fisico' => $estadoFisico,
                    'estado' => 'Activo',
                    'fecha_publicacion' => now(),
                ]);

                return [$mascota, $reporte];
            });
        } catch (Throwable $e) {
            if ($rutaFotografia) {
                Storage::disk('public')->delete($rutaFotografia);
            }

            throw $e;
        }

        return [$resultado[1], $codigoEdicionPlano];
    }

    private function generarCodigoReporteUnico(): string
    {
        do {
            $codigo = 'PR-' . Str::upper(Str::random(8));
        } while (Reporte::where('codigo_reporte', $codigo)->exists());

        return $codigo;
    }
}
