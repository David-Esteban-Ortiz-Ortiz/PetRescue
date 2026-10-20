@extends('layouts.app')

@section('title', 'Detalle de publicación | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">

            <div class="pet-card bg-white rounded-4 shadow-sm p-4 p-md-5">

                {{-- Encabezado --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

                    <div>
                        <span class="badge rounded-pill bg-primary-subtle text-primary mb-2">
                            Comunidad PetRescue
                        </span>

                        <h1 class="h2 fw-bold mb-2">
                            Detalle de la publicación
                        </h1>

                        <p class="text-secondary mb-0">
                            Consulta la información relacionada con esta publicación.
                        </p>
                    </div>

                    <div class="text-md-end">
                        <span class="text-secondary small d-block">
                            Código de publicación
                        </span>

                        <strong class="text-primary fs-5">
                            {{ $publicacion->codigo_publicacion }}
                        </strong>
                    </div>

                </div>

                <hr class="mb-4">

                {{-- Encabezado visual de la publicación --}}
                <div class="text-center mb-5">

                    <div class="mb-3">
                        <i
                            class="bi bi-chat-square-heart text-primary"
                            style="font-size: 4rem;"
                        ></i>
                    </div>

                    <h2 class="h4 fw-bold mb-2">
                        {{ $publicacion->titulo }}
                    </h2>

                    <p class="text-secondary mb-0">
                        Publicado el
                        {{ $publicacion->fecha_publicacion->format('d/m/Y \a \l\a\s H:i') }}
                    </p>

                </div>

                {{-- Información de la publicación --}}
                <div class="row g-4">

                    {{-- Tipo --}}
                    <div class="col-md-6">
                        <div class="border rounded-4 p-4 h-100 bg-light">

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-tag-fill text-primary"></i>

                                <h3 class="h6 fw-bold mb-0">
                                    Tipo de publicación
                                </h3>
                            </div>

                            <p class="text-secondary mb-0">
                                {{ $publicacion->tipo_publicacion }}
                            </p>

                        </div>
                    </div>

                    {{-- Autor --}}
                    <div class="col-md-6">
                        <div class="border rounded-4 p-4 h-100 bg-light">

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-person-circle text-primary"></i>

                                <h3 class="h6 fw-bold mb-0">
                                    Autor
                                </h3>
                            </div>

                            <p class="text-secondary mb-0">
                                {{ $publicacion->nombre_autor }}
                            </p>

                        </div>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-12">
                        <div class="border rounded-4 p-4 bg-light">

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-calendar3 text-primary"></i>

                                <h3 class="h6 fw-bold mb-0">
                                    Fecha de publicación
                                </h3>
                            </div>

                            <p class="text-secondary mb-0">
                                {{ $publicacion->fecha_publicacion->format('d/m/Y H:i') }}
                            </p>

                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div class="col-12">
                        <div class="border rounded-4 p-4">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-file-earmark-text text-primary"></i>

                                <h3 class="h5 fw-bold mb-0">
                                    Contenido
                                </h3>
                            </div>

                            <p class="text-secondary mb-0" style="white-space: pre-line; line-height: 1.7;">
                                {{ $publicacion->contenido }}
                            </p>

                        </div>
                    </div>

                    {{-- Fotografía --}}
                    <div class="col-12">
                        @if ($publicacion->fotografia)
                            <div class="border rounded-4 p-3 text-center bg-light">

                                <h3 class="h6 fw-bold mb-3">
                                    Fotografía de la publicación
                                </h3>

                                <img
                                    src="{{ asset('storage/' . $publicacion->fotografia) }}"
                                    alt="{{ $publicacion->titulo }}"
                                    class="img-fluid rounded-3"
                                    style="max-height: 500px; object-fit: contain;"
                                >

                            </div>
                        @else
                            <div class="border rounded-4 p-4 text-center bg-light">

                                <div class="mb-3">
                                    <i
                                        class="bi bi-image text-secondary"
                                        style="font-size: 3rem;"
                                    ></i>
                                </div>

                                <h3 class="h6 fw-bold">
                                    Sin fotografía
                                </h3>

                                <p class="text-secondary mb-0">
                                    Esta publicación no incluye fotografía.
                                </p>

                            </div>
                        @endif
                    </div>

                </div>

                {{-- Código --}}
                <div class="border rounded-4 p-4 mt-4 text-center">

                    <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                        <i class="bi bi-hash text-primary"></i>

                        <span class="fw-semibold">
                            Código consultado
                        </span>
                    </div>

                    <span class="text-primary fw-bold fs-5">
                        {{ $publicacion->codigo_publicacion }}
                    </span>

                </div>

                {{-- Acciones --}}
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">

                    <a
                        href="{{ route('comunidad.index') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2"
                    >
                        <i class="bi bi-arrow-left me-2"></i>
                        Volver a la comunidad
                    </a>

                    <a
                        href="{{ route('comunidad.crear') }}"
                        class="btn btn-pet-primary rounded-pill px-4 py-2"
                    >
                        <i class="bi bi-plus-circle me-2"></i>
                        Crear publicación
                    </a>

                </div>

            </div>

        </div>
    </div>

</section>

<hr class="my-5">

<!-- SECCIÓN DE COMENTARIOS -->
<div class="mt-4 mb-5">
    <h3 class="h4 fw-bold mb-4">Comentarios ({{ $publicacion->comentarios->count() }})</h3>

    <!-- Lista de comentarios -->
    <div class="mb-4">
        @forelse ($publicacion->comentarios as $comentario)
            <div class="card mb-3 border-0 bg-light rounded-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong class="text-primary">
                            <i class="bi bi-person-circle me-1"></i> {{ $comentario->nombre_autor }}
                        </strong>
                        <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-0">{{ $comentario->contenido }}</p>
                </div>
            </div>
        @empty
            <p class="text-secondary">Aún no hay comentarios. ¡Sé el primero en aportar!</p>
        @endforelse
    </div>

    <!-- Formulario para comentar -->
    @auth
        <form action="{{ route('comentarios.publicacion.guardar', $publicacion->id) }}" method="POST" class="pet-form bg-light rounded-3 border">
            @csrf
            <h4 class="h6 fw-bold mb-3">Deja un comentario</h4>
            @if (session('exito'))
                <div class="alert alert-success py-2">{{ session('exito') }}</div>
            @endif
            <div class="mb-3">
                <textarea name="contenido" class="form-control" rows="3" placeholder="Escribe tu comentario aquí..." required></textarea>
            </div>
            <button type="submit" class="btn btn-pet-primary btn-sm">
                <i class="bi bi-send-fill me-1"></i> Publicar comentario
            </button>
        </form>
    @else
        <div class="alert alert-info d-flex align-items-center">
            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
            <div>Debes <a href="{{ route('login') }}" class="fw-bold">iniciar sesión</a> para poder comentar.</div>
        </div>
    @endauth
</div>
@include('partials.comentarios', ['publicacion' => $publicacion])
@endsection
