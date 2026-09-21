@extends('layouts.app')

@section('title', 'Detalle del reporte | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="mb-4">

                <a
                    href="{{ route('inicio') }}"
                    class="btn btn-outline-secondary rounded-pill btn-sm"
                >
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al inicio
                </a>

            </div>

            <div class="pet-card bg-white overflow-hidden">

                <div class="row g-0">

                    <div class="col-md-5">

                        @if ($reporte->mascota && $reporte->mascota->fotografia)
                            <img
                                src="{{ asset('storage/' . $reporte->mascota->fotografia) }}"
                                alt="{{ $reporte->mascota->nombre ?? 'Mascota' }}"
                                class="w-100 h-100"
                                style="object-fit: cover; min-height: 380px;"
                            >
                        @else
                            <img
                                src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=800"
                                alt="Sin fotografía"
                                class="w-100 h-100"
                                style="object-fit: cover; min-height: 380px;"
                            >
                        @endif

                    </div>

                    <div class="col-md-7">

                        <div class="p-4 p-lg-5">

                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">

                                <span
                                    class="badge rounded-pill
                                    {{ $reporte->tipo_reporte === 'Perdida'
                                        ? 'badge-loss'
                                        : 'badge-found' }}"
                                >
                                    {{ $reporte->tipo_reporte === 'Perdida' ? 'Mascota perdida' : 'Mascota encontrada' }}
                                </span>

                                <span class="badge text-bg-primary rounded-pill">
                                    {{ $reporte->codigo_reporte }}
                                </span>

                            </div>

                            <h1 class="h3 fw-bold mb-3">
                                {{ $reporte->mascota->nombre ?? 'Mascota sin nombre' }}
                            </h1>

                            <div class="row g-3 mb-4">

                                <div class="col-6">
                                    <p class="text-secondary small mb-1">
                                        <i class="bi bi-tag me-1"></i>
                                        Tipo
                                    </p>
                                    <p class="fw-semibold mb-0">
                                        {{ $reporte->mascota->tipo ?? 'No especificado' }}
                                    </p>
                                </div>

                                <div class="col-6">
                                    <p class="text-secondary small mb-1">
                                        <i class="bi bi-palette me-1"></i>
                                        Color principal
                                    </p>
                                    <p class="fw-semibold mb-0">
                                        {{ $reporte->mascota->color_principal ?? 'No especificado' }}
                                    </p>
                                </div>

                                <div class="col-6">
                                    <p class="text-secondary small mb-1">
                                        <i class="bi bi-rulers me-1"></i>
                                        Tamaño
                                    </p>
                                    <p class="fw-semibold mb-0">
                                        {{ $reporte->mascota->tamano ?? 'No especificado' }}
                                    </p>
                                </div>

                                <div class="col-6">
                                    <p class="text-secondary small mb-1">
                                        <i class="bi bi-gender-ambiguous me-1"></i>
                                        Sexo
                                    </p>
                                    <p class="fw-semibold mb-0">
                                        {{ $reporte->mascota->sexo ?? 'No especificado' }}
                                    </p>
                                </div>

                            </div>

                            <hr>

                            <h2 class="h6 fw-bold mt-4 mb-3">
                                <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                                Ubicación del {{ $reporte->tipo_reporte === 'Perdida' ? 'extravío' : 'hallazgo' }}
                            </h2>

                            <p class="mb-2">
                                <strong>Ciudad:</strong>
                                {{ $reporte->ciudad }}
                            </p>

                            <p class="mb-2">
                                <strong>Barrio:</strong>
                                {{ $reporte->barrio }}
                            </p>

                            <p class="mb-2">
                                <strong>Referencia:</strong>
                                {{ $reporte->direccion_referencia }}
                            </p>

                            <p class="mb-0">
                                <strong>Fecha:</strong>
                                {{ $reporte->fecha_suceso ? $reporte->fecha_suceso->format('d/m/Y') : 'No especificada' }}
                                @if ($reporte->hora_aproximada)
                                    a las {{ $reporte->hora_aproximada }}
                                @endif
                            </p>

                            <hr>

                            <h2 class="h6 fw-bold mt-4 mb-3">
                                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                Descripción
                            </h2>

                            <p class="mb-0">
                                {{ $reporte->descripcion }}
                            </p>

                            @if ($reporte->mascota && $reporte->mascota->caracteristicas_particulares)
                                <hr>

                                <h2 class="h6 fw-bold mt-4 mb-3">
                                    <i class="bi bi-stars text-primary me-2"></i>
                                    Características particulares
                                </h2>

                                <p class="mb-0">
                                    {{ $reporte->mascota->caracteristicas_particulares }}
                                </p>
                            @endif

                            @if ($reporte->tipo_reporte === 'Hallazgo')

                                <hr>

                                <h2 class="h6 fw-bold mt-4 mb-3">
                                    <i class="bi bi-heart-pulse-fill text-danger me-2"></i>
                                    Estado y ubicación actual
                                </h2>

                                <p class="mb-2">
                                    <strong>Estado físico:</strong>
                                    {{ $reporte->estado_fisico ?? 'No especificado' }}
                                </p>

                                <p class="mb-0">
                                    <strong>Ubicación actual:</strong>
                                    {{ $reporte->ubicacion_actual ?? 'No especificada' }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

            <div class="pet-card bg-white p-4 mt-4">

                <h2 class="h5 fw-bold mb-3">
                    <i class="bi bi-telephone-fill text-success me-2"></i>
                    Información de contacto
                </h2>

                <div class="row g-3">

                    <div class="col-md-6">
                        <p class="text-secondary small mb-1">
                            <i class="bi bi-person me-1"></i>
                            Nombre
                        </p>
                        <p class="fw-semibold mb-0">
                            {{ $reporte->nombre_contacto ?? 'No disponible' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="text-secondary small mb-1">
                            <i class="bi bi-telephone me-1"></i>
                            Teléfono
                        </p>
                        <p class="fw-semibold mb-0">
                            {{ $reporte->telefono_contacto ?? 'No disponible' }}
                        </p>
                    </div>

                    @if ($reporte->correo_contacto)
                        <div class="col-md-6">
                            <p class="text-secondary small mb-1">
                                <i class="bi bi-envelope me-1"></i>
                                Correo electrónico
                            </p>
                            <p class="fw-semibold mb-0">
                                {{ $reporte->correo_contacto }}
                            </p>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <p class="text-secondary small mb-1">
                            <i class="bi bi-chat-dots me-1"></i>
                            Medio preferido
                        </p>
                        <p class="fw-semibold mb-0">
                            {{ $reporte->medio_contacto_preferido ?? 'No especificado' }}
                        </p>
                    </div>

                </div>

            </div>

            <div class="text-center mt-4 mb-5">

                <a
                    href="{{ route('inicio') }}"
                    class="btn btn-pet-secondary rounded-pill px-4"
                >
                    <i class="bi bi-house-door me-1"></i>
                    Volver a los reportes
                </a>

            </div>

        </div>

    </div>

</section>
@endsection
