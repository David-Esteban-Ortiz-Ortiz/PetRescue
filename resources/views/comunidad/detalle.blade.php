@extends('layouts.app')

@section('title', 'Detalle de publicación | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="pet-card bg-white p-5 text-center">

                <i class="bi bi-file-earmark-text text-primary" style="font-size: 4rem;"></i>

                <h1 class="h3 fw-bold mt-3">
                    Detalle de la publicación
                </h1>

                <p class="text-secondary mb-4">
                    Código consultado:
                    <strong>{{ $codigoPublicacion }}</strong>
                </p>

                <div class="alert alert-info mb-4">
                    <i class="bi bi-tools me-2"></i>
                    <strong>Vista en construcción.</strong>
                    Aquí se mostrará la publicación completa.
                </div>

                <a
                    href="{{ route('comunidad.index') }}"
                    class="btn btn-pet-secondary rounded-pill px-4"
                >
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver a la comunidad
                </a>

            </div>

        </div>

    </div>

</section>
@endsection
