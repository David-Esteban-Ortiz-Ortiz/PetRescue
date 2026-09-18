@extends('layouts.app')

@section('title', 'Mi perfil | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row g-4">

        <div class="col-lg-4">

            <div class="pet-card bg-white p-4 text-center">

                <img
                    src="{{ asset('images/icono-petrescue.png') }}"
                    alt="Icono de PetRescue"
                    width="120"
                >

                <h2 class="h4 fw-bold mt-3 mb-1">
                    {{ auth()->user()->name ?? 'Usuario' }}
                </h2>

                <p class="text-secondary mb-3">
                    Propietario de mascota
                </p>

                <span class="badge text-bg-success rounded-pill mb-4">
                    <i class="bi bi-check-circle me-1"></i>
                    Cuenta activa
                </span>

                <hr>

                <div class="text-start">

                    <p class="mb-2">
                        <i class="bi bi-person-fill text-primary me-2"></i>
                        {{ auth()->user()->name ?? 'Usuario' }}
                    </p>

                    <p class="mb-2">
                        <i class="bi bi-envelope-fill text-primary me-2"></i>
                        {{ auth()->user()->email ?? 'correo@ejemplo.com' }}
                    </p>

                    <p class="mb-0">
                        <i class="bi bi-telephone-fill text-primary me-2"></i>
                        {{ auth()->user()->telefono_principal ?? 'Sin teléfono' }}
                    </p>

                </div>

            </div>

            <div class="pet-card bg-white p-4 mt-4">

                <h2 class="h5 fw-bold mb-3">
                    Accesos rápidos
                </h2>

                <div class="d-grid gap-2">

                    <a
                        href="{{ route('reportes.perdida') }}"
                        class="btn btn-pet-secondary"
                    >
                        <i class="bi bi-search-heart me-1"></i>
                        Reportar pérdida
                    </a>

                    <a
                        href="{{ route('reportes.hallazgo') }}"
                        class="btn btn-pet-primary"
                    >
                        <i class="bi bi-geo-alt-fill me-1"></i>
                        Reportar hallazgo
                    </a>

                    <a
                        href="{{ route('inicio') }}"
                        class="btn btn-outline-secondary rounded-pill"
                    >
                        <i class="bi bi-house-door me-1"></i>
                        Volver al inicio
                    </a>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="pet-form">

                <div class="mb-4">
                    <span class="badge text-bg-primary rounded-pill mb-2">
                        HU3
                    </span>

                    <h2 class="h3 fw-bold">
                        Actualizar información de contacto
                    </h2>

                    <p class="text-secondary mb-0">
                        Mantén tus datos actualizados para que puedan
                        contactarte cuando tu mascota sea encontrada.
                    </p>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Los datos actualizados quedarán asociados con tus
                    mascotas y reportes activos.
                </div>

                <form
                    action="{{ route('perfil.contacto.actualizar') }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <h3 class="h5 fw-bold mt-4 mb-3">
                        <i class="bi bi-person-fill text-primary me-2"></i>
                        Información personal
                    </h3>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">
                            Nombre completo
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre', auth()->user()->name ?? '') }}"
                            placeholder="Ingresa tu nombre completo"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label
                                for="telefono_principal"
                                class="form-label"
                            >
                                Teléfono principal
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="tel"
                                class="form-control"
                                id="telefono_principal"
                                name="telefono_principal"
                                value="{{ old('telefono_principal', auth()->user()->telefono_principal ?? '') }}"
                                placeholder="Ejemplo: 3001234567"
                                minlength="7"
                                maxlength="15"
                                required
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label
                                for="telefono_alternativo"
                                class="form-label"
                            >
                                Teléfono alternativo
                            </label>

                            <input
                                type="tel"
                                class="form-control"
                                id="telefono_alternativo"
                                name="telefono_alternativo"
                                value="{{ old('telefono_alternativo', auth()->user()->telefono_alternativo ?? '') }}"
                                placeholder="Número de contacto adicional"
                                minlength="7"
                                maxlength="15"
                            >
                        </div>

                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">
                            Correo electrónico
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="correo"
                            name="correo"
                            value="{{ old('correo', auth()->user()->email ?? '') }}"
                            placeholder="nombre@correo.com"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="ciudad" class="form-label">
                                Ciudad o municipio
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="ciudad"
                                name="ciudad"
                                value="{{ old('ciudad', auth()->user()->ciudad ?? 'Pasto') }}"
                                maxlength="100"
                                required
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label
                                for="medio_contacto"
                                class="form-label"
                            >
                                Medio de contacto preferido
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                class="form-select"
                                id="medio_contacto"
                                name="medio_contacto"
                                required
                            >
                                <option value="">
                                    Seleccione una opción
                                </option>

                                <option
                                    value="Telefono"
                                    {{ old('medio_contacto', auth()->user()->medio_contacto_preferido ?? '') == 'Telefono' ? 'selected' : '' }}
                                >
                                    Llamada telefónica
                                </option>

                                <option
                                    value="WhatsApp"
                                    {{ old('medio_contacto', auth()->user()->medio_contacto_preferido ?? '') == 'WhatsApp' ? 'selected' : '' }}
                                >
                                    WhatsApp
                                </option>

                                <option
                                    value="Correo"
                                    {{ old('medio_contacto', auth()->user()->medio_contacto_preferido ?? '') == 'Correo' ? 'selected' : '' }}
                                >
                                    Correo electrónico
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="mb-4">
                        <label
                            for="horario_contacto"
                            class="form-label"
                        >
                            Horario de contacto
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="horario_contacto"
                            name="horario_contacto"
                            value="{{ old('horario_contacto', auth()->user()->horario_contacto ?? '') }}"
                            placeholder="Ejemplo: De 8:00 a. m. a 8:00 p. m."
                        >

                        <div class="form-text">
                            Este campo es opcional.
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="confirmar_datos"
                            name="confirmar_datos"
                            value="1"
                            required
                        >

                        <label
                            class="form-check-label"
                            for="confirmar_datos"
                        >
                            Confirmo que los datos de contacto ingresados
                            están actualizados.
                        </label>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-3">

                        <button
                            type="submit"
                            class="btn btn-pet-primary"
                        >
                            <i class="bi bi-floppy-fill me-1"></i>
                            Guardar cambios
                        </button>

                        <button
                            type="reset"
                            class="btn btn-outline-warning rounded-pill"
                        >
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Restablecer
                        </button>

                        <a
                            href="{{ route('inicio') }}"
                            class="btn btn-outline-secondary rounded-pill"
                        >
                            <i class="bi bi-x-circle me-1"></i>
                            Cancelar
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>
@endsection
