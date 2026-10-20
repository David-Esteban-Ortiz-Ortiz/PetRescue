@extends('layouts.app')

@section('title', 'Comunidad | PetRescue')

@section('content')
<section class="container py-5">

    {{-- ENCABEZADO --}}
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">

            <span class="badge rounded-pill bg-primary-subtle text-primary mb-3">
                Comunidad PetRescue
            </span>

            <h1 class="display-6 fw-bold mb-3">
                Historias que conectan a nuestra comunidad
            </h1>

            <p class="lead text-secondary mb-0">
                Comparte consejos, historias y experiencias relacionadas
                con el cuidado y bienestar de las mascotas.
            </p>
        </div>

        <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
            <a
                href="{{ route('comunidad.crear') }}"
                class="btn btn-pet-primary rounded-pill px-4 py-2"
            >
                <i class="bi bi-plus-circle me-2"></i>
                Compartir una publicación
            </a>
        </div>
    </div>

    {{-- MENSAJE DE ÉXITO --}}
    @if (session('exito'))
        <div class="alert alert-success rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('exito') }}
        </div>
    @endif

    {{-- NUEVA SECCIÓN DE BÚSQUEDA Y FILTROS HU7 --}}

    <div class="pet-card bg-white p-4 mb-4">

        <div class="mb-3">
            <h2 class="h5 fw-bold mb-1">
                <i class="bi bi-search me-2 text-primary"></i>
                Buscar publicaciones
            </h2>

            <p class="text-secondary small mb-0">
                Encuentra consejos, historias y experiencias
                compartidas por nuestra comunidad.
            </p>
        </div>

        <form
            action="{{ url('/comunidad') }}"
            method="GET"
            class="row g-3 align-items-end"
            id="formFiltrosComunidad"
        >

            {{-- CAMPO DE BÚSQUEDA --}}
            <div class="col-lg-5">

                <label for="buscarPublicacion" class="form-label">
                    Buscar por palabra clave
                </label>

                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>

                    <input
                        type="search"
                        name="buscar"
                        id="buscarPublicacion"
                        class="form-control"
                        placeholder="Título, autor o contenido..."
                        value="{{ request('buscar') }}"
                    >
                </div>
            </div>

            {{-- FILTRO POR TIPO DE PUBLICACIÓN --}}
            <div class="col-lg-4">

                <label for="tipoPublicacion" class="form-label">
                    Tipo de publicación
                </label>

                <select
                    name="tipo_publicacion"
                    id="tipoPublicacion"
                    class="form-select"
                >
                    <option value="">
                        Todos los tipos
                    </option>
                    {{-- CORRECCIÓN: Los valores ahora coinciden con la BD (Mayúscula) --}}
                    <option value="Consejo"
                        @selected(request('tipo_publicacion') === 'Consejo')>
                        Consejo
                    </option>

                    <option value="Historia"
                        @selected(request('tipo_publicacion') === 'Historia')>
                        Historia
                    </option>

                    <option value="Experiencia"
                        @selected(request('tipo_publicacion') === 'Experiencia')>
                        Experiencia
                    </option>

                    <option value="Actividad"
                        @selected(request('tipo_publicacion') === 'Actividad')>
                        Actividad
                    </option>

                    <option value="Informacion"
                        @selected(request('tipo_publicacion') === 'Informacion')>
                        Información
                    </option>

                </select>
            </div>

            {{-- BOTONES --}}
            <div class="col-lg-3">

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-pet-primary flex-grow-1"
                    >
                        <i class="bi bi-funnel me-1"></i>
                        Filtrar
                    </button>

                    <a
                        href="{{ url('/comunidad') }}"
                        class="btn btn-outline-secondary"
                    >
                        Limpiar
                    </a>

                </div>
            </div>

        </form>
    </div>

    {{-- ESTADO VACÍO --}}
    @if (empty($publicaciones) || count($publicaciones) === 0)

        <div class="pet-card bg-white p-5 text-center">

            <div class="mb-3">
                <i
                    class="bi bi-chat-heart text-primary"
                    style="font-size: 4rem;"
                ></i>
            </div>

            <h2 class="h4 fw-bold mb-3">
                Aún no hay publicaciones
            </h2>

            <p class="text-secondary mb-4">
                Sé el primero en compartir un consejo, una historia
                o una experiencia con la comunidad PetRescue.
            </p>

            <a
                href="{{ route('comunidad.crear') }}"
                class="btn btn-pet-primary rounded-pill px-4"
            >
                <i class="bi bi-plus-circle me-2"></i>
                Crear la primera publicación
            </a>

        </div>

    @else

        {{-- LISTADO DE PUBLICACIONES --}}
        <div class="row g-4" id="contenedorPublicaciones">

            @foreach ($publicaciones as $publicacion)

                <div
                    class="col-md-6 col-lg-4 publicacion-item"
                    {{-- CORRECCIÓN: Ahora usa tipo_publicacion en lugar de tipo --}}
                    data-busqueda="{{ trim(
                        ($publicacion->titulo ?? '') . ' ' .
                        ($publicacion->nombre_autor ?? '') . ' ' .
                        ($publicacion->contenido ?? '') . ' ' .
                        ($publicacion->tipo_publicacion ?? '')
                    ) }}"
                    data-tipo="{{ $publicacion->tipo_publicacion ?? '' }}"
                >

                    <article class="card pet-card h-100 border-0">

                        {{-- FOTOGRAFÍA --}}
                        @if (!empty($publicacion->fotografia))
                            <img
                                src="{{ asset('storage/' . $publicacion->fotografia) }}"
                                class="card-img-top"
                                alt="Fotografía de la publicación"
                                style="height: 220px; object-fit: cover;"
                            >
                        @endif

                        <div class="card-body d-flex flex-column">

                            {{-- TIPO DE PUBLICACIÓN --}}
                            {{-- CORRECCIÓN: Ahora usa tipo_publicacion en lugar de tipo --}}
                            @if (!empty($publicacion->tipo_publicacion))
                                <div class="mb-3">

                                    <span class="badge rounded-pill bg-primary-subtle text-primary">
                                        {{ ucfirst($publicacion->tipo_publicacion) }}
                                    </span>

                                </div>
                            @endif

                            {{-- TÍTULO --}}
                            @if (!empty($publicacion->titulo))
                                <h3 class="h5 fw-bold mb-2">
                                    {{ $publicacion->titulo }}
                                </h3>
                            @endif

                            {{-- AUTOR --}}
                            @if (!empty($publicacion->nombre_autor))
                                <p class="text-secondary small mb-3">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ $publicacion->nombre_autor }}
                                </p>
                            @endif

                            {{-- CONTENIDO --}}
                            @if (!empty($publicacion->contenido))
                                <p class="text-secondary">
                                    {{ \Illuminate\Support\Str::limit($publicacion->contenido, 120) }}
                                </p>
                            @endif

                            {{-- BOTÓN DE DETALLE --}}
                            @if (!empty($publicacion->codigo_publicacion))
                                <div class="mt-auto">

                                    <a
                                        href="{{ route('comunidad.detalle', $publicacion->codigo_publicacion) }}"
                                        class="btn btn-outline-primary rounded-pill w-100"
                                    >
                                        Ver publicación
                                    </a>

                                </div>
                            @endif

                        </div>

                    </article>

                </div>

            @endforeach

        </div>

        {{-- MENSAJE SIN RESULTADOS --}}
        <div
            class="alert alert-warning rounded-4 mt-4 d-none"
            id="mensajeSinResultadosComunidad"
        >
            <i class="bi bi-exclamation-circle me-2"></i>
            No se encontraron publicaciones que coincidan con
            los filtros seleccionados.
        </div>

    @endif

</section>
@endsection

{{-- JAVASCRIPT PARA FILTROS DE COMUNIDAD --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const publicaciones = document.querySelectorAll('.publicacion-item');

    const mensajeSinResultados = document.getElementById(
        'mensajeSinResultadosComunidad'
    );

    // Leer los filtros enviados por el formulario GET
    const parametros = new URLSearchParams(window.location.search);

    const textoBusqueda = parametros.get('buscar') || '';
    const tipoSeleccionado = parametros.get('tipo_publicacion') || '';

    // Normalizar texto: minúsculas y sin tildes
    function normalizar(texto) {
        return String(texto || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();
    }

    function aplicarFiltros() {

        const busqueda = normalizar(textoBusqueda);
        const tipoFiltro = normalizar(tipoSeleccionado);

        let resultadosVisibles = 0;

        publicaciones.forEach(function (publicacion) {

            const contenido = normalizar(publicacion.dataset.busqueda);
            const tipo = normalizar(publicacion.dataset.tipo);

            // Búsqueda por título, autor o contenido
            const coincideBusqueda =
                busqueda === '' ||
                contenido.includes(busqueda);

            // Filtro por tipo de publicación
            const coincideTipo =
                tipoFiltro === '' ||
                tipo === tipoFiltro;

            if (coincideBusqueda && coincideTipo) {

                publicacion.classList.remove('d-none');
                resultadosVisibles++;

            } else {

                publicacion.classList.add('d-none');

            }

        });

        // Mensaje cuando no existen coincidencias
        if (mensajeSinResultados) {

            mensajeSinResultados.classList.toggle(
                'd-none',
                resultadosVisibles > 0
            );

        }

    }

    aplicarFiltros();

});
</script>
@endpush
