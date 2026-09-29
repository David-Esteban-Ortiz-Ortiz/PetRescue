@extends('layouts.app')

@section('title', 'Publicación creada | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="pet-card bg-white rounded-4 shadow-sm p-4 p-md-5 text-center">

                {{-- Icono de confirmación --}}
                <div class="mb-4">
                    <i
                        class="bi bi-check-circle-fill text-success"
                        style="font-size: 4.5rem;"
                    ></i>
                </div>

                {{-- Título --}}
                <h1 class="h2 fw-bold mb-3">
                    ¡Publicación creada correctamente!
                </h1>

                <p class="text-secondary mb-4">
                    Tu publicación fue registrada en la comunidad PetRescue.
                    Ahora otros usuarios podrán verla cuando el servicio de
                    publicaciones esté disponible.
                </p>

                {{-- Bloque informativo --}}
                <div class="bg-light border rounded-4 p-4 mb-4">

                    <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                        <i class="bi bi-info-circle text-primary"></i>

                        <span class="fw-semibold">
                            Publicación registrada
                        </span>
                    </div>

                    <p class="text-secondary mb-0">
                        Guarda esta confirmación como referencia de que
                        la publicación fue enviada correctamente.
                    </p>

                </div>

                {{-- Acciones --}}
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">

                    <a
                        href="{{ route('comunidad.index') }}"
                        class="btn btn-pet-primary rounded-pill px-4 py-2"
                    >
                        <i class="bi bi-people-fill me-2"></i>
                        Ir a la comunidad
                    </a>

                    <a
                        href="{{ route('comunidad.crear') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2"
                    >
                        <i class="bi bi-plus-circle me-2"></i>
                        Crear otra publicación
                    </a>

                </div>

            </div>

        </div>
    </div>

</section>
@endsection
