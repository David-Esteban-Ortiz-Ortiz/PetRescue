@extends('layouts.app')

@section('title', 'Reporte publicado | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="pet-form">

                <div class="text-center mb-4">

                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>

                    <h1 class="h3 fw-bold mt-3">
                        ¡Reporte publicado correctamente!
                    </h1>

                    <p class="text-secondary mb-0">
                        Tu reporte ya está visible en la página principal
                        de PetRescue.
                    </p>

                </div>

                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Importante:</strong> guarda el código de edición
                    en un lugar seguro. No lo mostraremos otra vez.
                    Lo necesitarás para actualizar la información de contacto.
                </div>

                <div class="card mb-4">

                    <div class="card-body">

                        <h2 class="h5 fw-bold mb-3">
                            <i class="bi bi-tag-fill text-primary me-2"></i>
                            Código público del reporte
                        </h2>

                        <p class="text-secondary mb-2">
                            Este código identifica tu reporte. Puedes
                            compartirlo con otras personas.
                        </p>

                        <div class="input-group mb-0">

                            <input
                                type="text"
                                class="form-control form-control-lg fw-bold text-center"
                                value="{{ $codigoReporte }}"
                                readonly
                                onclick="this.select()"
                            >

                        </div>

                    </div>

                </div>

                <div class="card mb-4 border-warning">

                    <div class="card-body">

                        <h2 class="h5 fw-bold mb-3">
                            <i class="bi bi-shield-lock-fill text-warning me-2"></i>
                            Código privado de edición
                        </h2>

                        <p class="text-secondary mb-2">
                            Con este código puedes actualizar la información
                            de contacto del reporte. <strong>No lo compartas
                            con nadie.</strong>
                        </p>

                        <div class="input-group mb-0">

                            <input
                                type="text"
                                class="form-control form-control-lg fw-bold text-center"
                                value="{{ $codigoEdicion }}"
                                readonly
                                onclick="this.select()"
                            >

                        </div>

                    </div>

                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Guarda ambos códigos. Si pierdes el código privado,
                    no podrás editar tu reporte después.
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3 mt-4">

                    <a
                        href="{{ route('inicio') }}"
                        class="btn btn-pet-primary flex-fill"
                    >
                        <i class="bi bi-house-door me-1"></i>
                        Volver al inicio
                    </a>

                    <a
                        href="{{ route('reportes.detalle', $codigoReporte) }}"
                        class="btn btn-pet-secondary flex-fill"
                    >
                        <i class="bi bi-eye me-1"></i>
                        Ver mi reporte
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>
@endsection
