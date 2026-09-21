@extends('layouts.app')

@section('title', 'Bienvenida | PetRescue')

@section('content')
<section class="hero-petrescue">
    <div class="container py-5">
        <div class="row align-items-center g-5">

            <div class="col-lg-7 text-white">
                <img
                    src="{{ asset('images/icono-petrescue.png') }}"
                    alt="PetRescue"
                    class="hero-logo mb-4"
                >

                <h1 class="display-5 fw-bold">
                    Juntos podemos ayudarles a volver a casa
                </h1>

                <p class="lead mt-3 mb-4">
                    Publica una mascota perdida o encontrada sin necesidad
                    de crear una cuenta. Ayúdanos a reunirlas con sus familias.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a
                        href="{{ route('reportes.perdida') }}"
                        class="btn btn-pet-primary"
                    >
                        <i class="bi bi-search-heart me-1"></i>
                        Reportar mascota perdida
                    </a>

                    <a
                        href="{{ route('reportes.hallazgo') }}"
                        class="btn btn-light rounded-pill px-4 py-2"
                    >
                        <i class="bi bi-geo-alt-fill me-1"></i>
                        Reportar mascota encontrada
                    </a>
                </div>

                <p class="small mt-3 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    No necesitas registrarte ni iniciar sesión.
                </p>
            </div>

            <div class="col-lg-5">
                <div class="pet-card bg-white p-4">
                    <h2 class="h4 fw-bold">
                        ¿Cómo puedes ayudar?
                    </h2>

                    <div class="d-flex gap-3 mt-4">
                        <i class="bi bi-search fs-2 text-primary"></i>
                        <div>
                            <h3 class="h6 fw-bold">Reporta una pérdida</h3>
                            <p class="text-secondary mb-0">
                                Publica información para iniciar la búsqueda.
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-3">
                        <i class="bi bi-geo-alt fs-2 text-warning"></i>
                        <div>
                            <h3 class="h6 fw-bold">Registra un hallazgo</h3>
                            <p class="text-secondary mb-0">
                                Ayuda a localizar al propietario de una mascota.
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-3">
                        <i class="bi bi-pencil-square fs-2 text-success"></i>
                        <div>
                            <h3 class="h6 fw-bold">Actualiza tu contacto</h3>
                            <p class="text-secondary mb-0">
                                Con tus códigos puedes editar la información
                                de contacto de tu reporte.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
