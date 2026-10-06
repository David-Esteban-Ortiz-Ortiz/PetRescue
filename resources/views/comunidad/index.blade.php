@extends('layouts.app')

@section('title', 'Comunidad | PetRescue')

@section('content')
<section class="container py-5">

    {{-- Encabezado --}}
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <span class="badge rounded-pill bg-primary-subtle text-primary mb-3">
                Comunidad PetRescue
            </span>

            <h1 class="display-6 fw-bold mb-3">
                Historias que conectan a nuestra comunidad
            </h1>

            <p class="lead text-secondary mb-0">
                Comparte consejos, historias y experiencias relacionadas con el cuidado y bienestar de las mascotas.
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

    {{-- Mensaje de éxito --}}
    @if (session('exito'))
        <div class="alert alert-success rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('exito') }}
        </div>
    @endif

    {{-- Estado vacío --}}
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

        {{-- Listado de publicaciones --}}
        <div class="row g-4">

            @foreach ($publicaciones as $publicacion)

                <div class="col-md-6 col-lg-4">

                    <article class="card pet-card h-100 border-0">

                        {{-- Fotografía --}}
                        @if (!empty($publicacion->fotografia))
                            <img
                                src="{{ asset('storage/' . $publicacion->fotografia) }}"
                                class="card-img-top"
                                alt="Fotografía de la publicación"
                                style="height: 220px; object-fit: cover;"
                            >
                        @endif

                        <div class="card-body d-flex flex-column">

                            {{-- Badge de tipo --}}
                            @if (!empty($publicacion->tipo))
                                <div class="mb-3">
                                    <span class="badge rounded-pill bg-primary-subtle text-primary">
                                        {{ ucfirst($publicacion->tipo) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Título --}}
                            @if (!empty($publicacion->titulo))
                                <h3 class="h5 fw-bold mb-2">
                                    {{ $publicacion->titulo }}
                                </h3>
                            @endif

                            {{-- Autor --}}
                            @if (!empty($publicacion->nombre_autor))
                                <p class="text-secondary small mb-3">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ $publicacion->nombre_autor }}
                                </p>
                            @endif

                            {{-- Contenido --}}
                            @if (!empty($publicacion->contenido))
                                <p class="text-secondary">
                                    {{ \Illuminate\Support\Str::limit($publicacion->contenido, 120) }}
                                </p>
                            @endif

                            {{-- Detalle --}}
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

    @endif

</section>
@endsection
