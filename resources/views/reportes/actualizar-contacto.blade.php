@extends('layouts.app')

@section('title', 'Actualizar información de contacto | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-6">

            <div class="pet-form">

                <div class="text-center mb-4">

                    <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3.5rem;"></i>

                    <h1 class="h3 fw-bold mt-3">
                        Actualizar información de contacto
                    </h1>

                    <p class="text-secondary mb-0">
                        Ingresa los códigos de tu reporte para poder
                        modificar los datos de contacto.
                    </p>

                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form
                    action="{{ route('reportes.verificar-codigos') }}"
                    method="POST"
                    id="formularioVerificacion"
                >
                    @csrf

                    <div class="mb-3">
                        <label for="codigo_reporte" class="form-label">
                            Código público del reporte
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control form-control-lg @error('codigo_reporte') is-invalid @enderror"
                            id="codigo_reporte"
                            name="codigo_reporte"
                            value="{{ old('codigo_reporte') }}"
                            placeholder="Ejemplo: PR-ABCD1234"
                            maxlength="30"
                            required
                        >

                        <div class="form-text">
                            Este es el código que identifica tu reporte.
                            Se mostró al publicarlo.
                        </div>

                        @error('codigo_reporte')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="codigo_edicion" class="form-label">
                            Código privado de edición
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control form-control-lg @error('codigo_edicion') is-invalid @enderror"
                            id="codigo_edicion"
                            name="codigo_edicion"
                            placeholder="Ingresa tu código privado"
                            maxlength="100"
                            required
                        >

                        <div class="form-text">
                            Solo tú debes conocer este código.
                        </div>

                        @error('codigo_edicion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="btn btn-pet-primary w-100"
                    >
                        <i class="bi bi-shield-check me-1"></i>
                        Verificar códigos
                    </button>

                </form>

                <hr class="my-4">

                <div class="text-center">

                    <p class="text-secondary mb-2">
                        ¿Perdiste tu reporte o no tienes los códigos?
                    </p>

                    <a
                        href="{{ route('inicio') }}"
                        class="btn btn-outline-secondary rounded-pill"
                    >
                        <i class="bi bi-arrow-left me-1"></i>
                        Volver al inicio
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>
@endsection
