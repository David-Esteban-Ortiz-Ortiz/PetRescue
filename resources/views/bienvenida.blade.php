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
                    Publica reportes de mascotas perdidas o encontradas
                    y contribuye a reunirlas con sus familias.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a
                        href="{{ route('login') }}"
                        class="btn btn-pet-primary"
                    >
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Iniciar sesión
                    </a>

                    <a
                        href="{{ route('registro') }}"
                        class="btn btn-light rounded-pill px-4 py-2"
                    >
                        <i class="bi bi-person-plus me-1"></i>
                        Crear cuenta
                    </a>
                </div>
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
                        <i class="bi bi-people fs-2 text-success"></i>
                        <div>
                            <h3 class="h6 fw-bold">Participa en la comunidad</h3>
                            <p class="text-secondary mb-0">
                                Consulta y comparte los reportes publicados.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
