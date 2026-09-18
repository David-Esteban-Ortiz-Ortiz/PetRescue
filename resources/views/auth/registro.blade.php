@extends('layouts.app')

@section('title', 'Crear cuenta | PetRescue')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="pet-form">

                <div class="text-center mb-4">
                    <img
                        src="{{ asset('images/icono-petrescue.png') }}"
                        alt="Icono de PetRescue"
                        width="90"
                    >

                    <h1 class="h3 fw-bold mt-3">
                        Crea tu cuenta en PetRescue
                    </h1>

                    <p class="text-secondary">
                        Registra tus datos para publicar y gestionar reportes.
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
                    action="{{ route('registro.guardar') }}"
                    method="POST"
                    id="formularioRegistro"
                    novalidate
                >
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Nombre completo
                        </label>

                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ingresa tu nombre completo"
                            autocomplete="name"
                            maxlength="150"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

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
                            maxlength="150"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telefono_principal" class="form-label">
                            Número de teléfono
                        </label>

                        <input
                            type="tel"
                            class="form-control @error('telefono_principal') is-invalid @enderror"
                            id="telefono_principal"
                            name="telefono_principal"
                            value="{{ old('telefono_principal') }}"
                            placeholder="Ingresa tu número de teléfono"
                            autocomplete="tel"
                            minlength="7"
                            maxlength="20"
                            required
                        >

                        @error('telefono_principal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                Contraseña
                            </label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Crea una contraseña"
                                    autocomplete="new-password"
                                    minlength="8"
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

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                Confirmar contraseña
                            </label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Repite la contraseña"
                                    autocomplete="new-password"
                                    minlength="8"
                                    required
                                >

                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    id="mostrarConfirmacion"
                                    aria-label="Mostrar u ocultar confirmación"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        id="mensajeContrasena"
                        class="text-danger small mb-3 d-none"
                    >
                        Las contraseñas no coinciden.
                    </div>

                    <div class="form-check mb-4">
                        <input
                            class="form-check-input @error('terminos') is-invalid @enderror"
                            type="checkbox"
                            id="terminos"
                            name="terminos"
                            value="1"
                            {{ old('terminos') ? 'checked' : '' }}
                            required
                        >

                        <label class="form-check-label" for="terminos">
                            Acepto los términos y condiciones de PetRescue.
                        </label>

                        @error('terminos')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="btn btn-pet-primary w-100"
                        id="botonRegistro"
                    >
                        <i class="bi bi-person-plus me-1"></i>
                        Crear cuenta
                    </button>
                </form>

                <p class="text-center mt-4 mb-0">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}">Inicia sesión</a>
                </p>

            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formularioRegistro = document.getElementById('formularioRegistro');
        const contrasena = document.getElementById('password');
        const confirmarContrasena = document.getElementById('password_confirmation');
        const mostrarContrasena = document.getElementById('mostrarContrasena');
        const mostrarConfirmacion = document.getElementById('mostrarConfirmacion');
        const mensajeContrasena = document.getElementById('mensajeContrasena');

        function alternarVisibilidad(input, boton) {
            const icono = boton.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icono.classList.remove('bi-eye');
                icono.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icono.classList.remove('bi-eye-slash');
                icono.classList.add('bi-eye');
            }
        }

        mostrarContrasena.addEventListener('click', function () {
            alternarVisibilidad(contrasena, mostrarContrasena);
        });

        mostrarConfirmacion.addEventListener('click', function () {
            alternarVisibilidad(confirmarContrasena, mostrarConfirmacion);
        });

        formularioRegistro.addEventListener('submit', function (evento) {
            if (contrasena.value !== confirmarContrasena.value) {
                evento.preventDefault();

                mensajeContrasena.classList.remove('d-none');
                confirmarContrasena.classList.add('is-invalid');
                confirmarContrasena.focus();
            } else {
                mensajeContrasena.classList.add('d-none');
                confirmarContrasena.classList.remove('is-invalid');
            }
        });
    });
</script>
@endpush
