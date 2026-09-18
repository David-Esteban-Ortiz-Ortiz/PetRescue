@extends('layouts.app')

@section('title', 'Inicio | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-6 fw-bold">
                ¿Cómo deseas ayudar?
            </h1>

            <p class="lead text-secondary mb-0">
                Publica un nuevo reporte o consulta las mascotas reportadas
                por la comunidad.
            </p>
        </div>

        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <img
                src="{{ asset('images/icono-petrescue.png') }}"
                alt="Icono de PetRescue"
                width="85"
                class="img-fluid"
            >
        </div>
    </div>

    <div class="row g-4 mb-5">

        <div class="col-md-6">
            <article class="action-card action-card-loss">
                <i class="bi bi-search-heart fs-1"></i>

                <h2 class="h3 fw-bold mt-3">
                    Perdí mi mascota
                </h2>

                <p>
                    Registra los datos de tu mascota y la información del lugar
                    donde ocurrió el extravío.
                </p>

                <a
                    href="{{ route('reportes.perdida') }}"
                    class="btn btn-light rounded-pill px-4"
                >
                    <i class="bi bi-plus-circle me-1"></i>
                    Reportar pérdida
                </a>
            </article>
        </div>

        <div class="col-md-6">
            <article class="action-card action-card-found">
                <i class="bi bi-geo-alt-fill fs-1"></i>

                <h2 class="h3 fw-bold mt-3">
                    Encontré una mascota
                </h2>

                <p>
                    Publica la información del hallazgo para ayudar a localizar
                    a su propietario.
                </p>

                <a
                    href="{{ route('reportes.hallazgo') }}"
                    class="btn btn-light rounded-pill px-4"
                >
                    <i class="bi bi-plus-circle me-1"></i>
                    Reportar hallazgo
                </a>
            </article>
        </div>

    </div>

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-end
               gap-3 mb-4"
    >
        <div>
            <h2 class="section-title h3 mb-1">
                Reportes recientes
            </h2>

            <p class="text-secondary mb-0">
                Consulta mascotas perdidas y encontradas.
            </p>
        </div>

        <div class="col-md-5">
            <label for="buscadorReportes" class="form-label">
                Buscar reportes
            </label>

            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>

                <input
                    type="search"
                    class="form-control"
                    id="buscadorReportes"
                    placeholder="Nombre, tipo o ubicación"
                >
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-4">
        <button
            type="button"
            class="btn btn-pet-secondary btn-sm px-4"
        >
            Todos
        </button>

        <button
            type="button"
            class="btn btn-outline-danger rounded-pill btn-sm px-4"
        >
            Mascotas perdidas
        </button>

        <button
            type="button"
            class="btn btn-outline-success rounded-pill btn-sm px-4"
        >
            Mascotas encontradas
        </button>
    </div>

    <div class="row g-4" id="contenedorReportes">

        @forelse ($reportes as $reporte)
            <div
                class="col-md-6 col-lg-4 reporte-item"
                data-nombre="{{ strtolower($reporte['nombre']) }}"
                data-tipo="{{ strtolower($reporte['tipo']) }}"
                data-ubicacion="{{ strtolower($reporte['ubicacion']) }}"
            >
                <article class="card pet-card h-100">

                    <img
                        src="{{ $reporte['imagen'] }}"
                        class="pet-report-image"
                        alt="{{ $reporte['nombre'] }}"
                    >

                    <div class="card-body d-flex flex-column">

                        <div class="d-flex justify-content-between gap-2 mb-2">
                            <h3 class="card-title h5 fw-bold mb-0">
                                {{ $reporte['nombre'] }}
                            </h3>

                            <span
                                class="badge rounded-pill
                                {{ $reporte['estado'] === 'Perdida'
                                    ? 'badge-loss'
                                    : 'badge-found' }}"
                            >
                                {{ $reporte['estado'] }}
                            </span>
                        </div>

                        <p class="card-text text-secondary mb-2">
                            <i class="bi bi-tag me-1"></i>
                            {{ $reporte['tipo'] }}
                        </p>

                        <p class="card-text mb-2">
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $reporte['ubicacion'] }}
                        </p>

                        <p class="card-text mb-4">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $reporte['fecha'] }}
                        </p>

                        <a
                            href="#"
                            class="btn btn-pet-secondary btn-sm mt-auto"
                        >
                            <i class="bi bi-eye me-1"></i>
                            Ver reporte
                        </a>

                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Todavía no existen reportes publicados.
                </div>
            </div>
        @endforelse

    </div>

    <div
        class="alert alert-warning mt-4 d-none"
        id="mensajeSinResultados"
    >
        <i class="bi bi-exclamation-circle me-2"></i>
        No se encontraron reportes con la búsqueda ingresada.
    </div>

</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscador = document.getElementById('buscadorReportes');
        const reportes = document.querySelectorAll('.reporte-item');
        const mensajeSinResultados = document.getElementById('mensajeSinResultados');

        if (!buscador) {
            return;
        }

        buscador.addEventListener('input', function () {
            const textoBusqueda = buscador.value.toLowerCase().trim();
            let resultadosVisibles = 0;

            reportes.forEach(function (reporte) {
                const nombre = reporte.dataset.nombre;
                const tipo = reporte.dataset.tipo;
                const ubicacion = reporte.dataset.ubicacion;

                const coincide =
                    nombre.includes(textoBusqueda) ||
                    tipo.includes(textoBusqueda) ||
                    ubicacion.includes(textoBusqueda);

                if (coincide) {
                    reporte.classList.remove('d-none');
                    resultadosVisibles++;
                } else {
                    reporte.classList.add('d-none');
                }
            });

            if (resultadosVisibles === 0 && textoBusqueda !== '') {
                mensajeSinResultados.classList.remove('d-none');
            } else {
                mensajeSinResultados.classList.add('d-none');
            }
        });
    });
</script>
@endpush
