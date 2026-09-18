@extends('layouts.app')

@section('title', 'Iniciar sesión | PetRescue')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="pet-form">

                <div class="text-center mb-4">
                    <img
                        src="{{ asset('images/icono-petrescue.png') }}"
                        alt="Icono de PetRescue"
                        width="90"
                    >

                    <h1 class="h3 fw-bold mt-3">
                        Bienvenido a PetRescue
                    </h1>

                    <p class="text-secondary">
                        Ingresa para gestionar tus mascotas y reportes.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('login.guardar') }}"
                    method="POST"
                    id="formularioLogin"
                    novalidate
                >
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nombre@correo.com"
                            autocomplete="email"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Contraseña
                        </label>

                        <div class="input-group">
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Ingresa tu contraseña"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                id="mostrarContrasena"
                                aria-label="Mostrar u ocultar contraseña"
                            >
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="remember"
                            name="remember"
                            value="1"
                        >

                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-pet-primary w-100"
                    >
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Iniciar sesión
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mt-3 mb-0">
                        ¿No tienes una cuenta?
                        <a href="{{ route('registro') }}">Regístrate</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contrasena = document.getElementById('password');
        const mostrarContrasena = document.getElementById('mostrarContrasena');

        if (!contrasena || !mostrarContrasena) {
            return;
        }

        mostrarContrasena.addEventListener('click', function () {
            const icono = mostrarContrasena.querySelector('i');

            if (contrasena.type === 'password') {
                contrasena.type = 'text';
                icono.classList.remove('bi-eye');
                icono.classList.add('bi-eye-slash');
            } else {
                contrasena.type = 'password';
                icono.classList.remove('bi-eye-slash');
                icono.classList.add('bi-eye');
            }
        });
    });
</script>
@endpush
