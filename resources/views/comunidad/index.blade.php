@extends('layouts.app')

@section('title', 'Comunidad | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-6 fw-bold">
                Comunidad PetRescue
            </h1>

            <p class="lead text-secondary mb-0">
                Consejos, historias y experiencias compartidas por la
                comunidad para el cuidado y bienestar de las mascotas.
            </p>
        </div>

        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <a
                href="{{ route('comunidad.crear') }}"
                class="btn btn-pet-primary rounded-pill px-4"
            >
                <i class="bi bi-plus-circle me-1"></i>
                Compartir una publicación
            </a>
        </div>
    </div>

    <div class="alert alert-info">
        <i class="bi bi-tools me-2"></i>
        <strong>Vista en construcción.</strong>
        Esta sección será reemplazada por el diseño final de la comunidad
        en los próximos días.
    </div>

    @if (empty($publicaciones))
        <div class="pet-card bg-white p-5 text-center">

            <i class="bi bi-chat-heart text-primary" style="font-size: 4rem;"></i>

            <h2 class="h4 fw-bold mt-3">
                Aún no hay publicaciones
            </h2>

            <p class="text-secondary mb-4">
                Sé el primero en compartir un consejo, una historia o una
                experiencia con la comunidad.
            </p>

            <a
                href="{{ route('comunidad.crear') }}"
                class="btn btn-pet-primary rounded-pill px-4"
            >
                <i class="bi bi-plus-circle me-1"></i>
                Crear la primera publicación
            </a>

        </div>
    @else
        <div class="row g-4">
            @foreach ($publicaciones as $publicacion)
                <div class="col-md-6 col-lg-4">
                    <article class="card pet-card h-100">
                        <div class="card-body">
                            <h3 class="h5 fw-bold">
                                {{ $publicacion->titulo }}
                            </h3>
                            <p class="text-secondary mb-0">
                                {{ $publicacion->nombre_autor }}
                            </p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif

</section>
@endsection
