@extends('layouts.app')

@section('title', 'Publicación creada | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="pet-card bg-white p-5 text-center">

                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>

                <h1 class="h3 fw-bold mt-3">
                    ¡Publicación creada!
                </h1>

                <p class="text-secondary mb-4">
                    Tu publicación fue registrada correctamente en la comunidad.
                </p>

                <div class="alert alert-info mb-4">
                    <i class="bi bi-tools me-2"></i>
                    <strong>Vista en construcción.</strong>
                    Aquí se mostrará el código público de la publicación.
                </div>

                <a
                    href="{{ route('comunidad.index') }}"
                    class="btn btn-pet-primary rounded-pill px-4"
                >
                    <i class="bi bi-people-fill me-1"></i>
                    Ir a la comunidad
                </a>

            </div>

        </div>

    </div>

</section>
@endsection
