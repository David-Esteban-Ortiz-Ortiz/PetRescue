@extends('layouts.app')

@section('title', 'Compartir publicación | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">

            <div class="pet-form bg-white rounded-4 shadow-sm p-4 p-md-5">

                {{-- Encabezado --}}
                <div class="mb-4">

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge text-bg-primary rounded-pill px-3 py-2">
                            HU4
                        </span>

                        <span class="text-secondary small">
                            Comunidad PetRescue
                        </span>
                    </div>

                    <h1 class="h2 fw-bold mb-2">
                        Comparte con la comunidad
                    </h1>

                    <p class="text-secondary mb-0">
                        Comparte un consejo, historia, experiencia,
                        actividad o información relacionada con el
                        cuidado y bienestar de las mascotas.
                    </p>

                </div>

                <hr class="mb-4">

                <form
                    action="{{ route('comunidad.guardar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    novalidate
                >
                    @csrf

                    {{-- Información del autor --}}
                    <div class="mb-4">

                        <h2 class="h5 fw-bold text-primary mb-3">
                            <i class="bi bi-person-circle me-2"></i>
                            Información del autor
                        </h2>

                        <div class="mb-3">

                            <label for="nombre_autor" class="form-label fw-semibold">
                                Nombre del autor
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control rounded-3 @error('nombre_autor') is-invalid @enderror"
                                id="nombre_autor"
                                name="nombre_autor"
                                value="{{ old('nombre_autor') }}"
                                maxlength="150"
                                placeholder="Ej: Carlos Pérez"
                                required
                            >

                            @error('nombre_autor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Información de la publicación --}}
                    <div class="mb-4">

                        <h2 class="h5 fw-bold text-primary mb-3">
                            <i class="bi bi-chat-heart me-2"></i>
                            Información de la publicación
                        </h2>

                        <div class="row g-3">

                            {{-- Título --}}
                            <div class="col-md-7">

                                <label for="titulo" class="form-label fw-semibold">
                                    Título
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control rounded-3 @error('titulo') is-invalid @enderror"
                                    id="titulo"
                                    name="titulo"
                                    value="{{ old('titulo') }}"
                                    maxlength="150"
                                    placeholder="Escribe un título para tu publicación"
                                    required
                                >

                                @error('titulo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Tipo --}}
                            <div class="col-md-5">

                                <label for="tipo_publicacion" class="form-label fw-semibold">
                                    Tipo de publicación
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    class="form-select rounded-3 @error('tipo_publicacion') is-invalid @enderror"
                                    id="tipo_publicacion"
                                    name="tipo_publicacion"
                                    required
                                >
                                    <option value="">
                                        Seleccione una opción
                                    </option>

                                    <option
                                        value="Consejo"
                                        {{ old('tipo_publicacion') === 'Consejo' ? 'selected' : '' }}
                                    >
                                        Consejo
                                    </option>

                                    <option
                                        value="Historia"
                                        {{ old('tipo_publicacion') === 'Historia' ? 'selected' : '' }}
                                    >
                                        Historia
                                    </option>

                                    <option
                                        value="Experiencia"
                                        {{ old('tipo_publicacion') === 'Experiencia' ? 'selected' : '' }}
                                    >
                                        Experiencia
                                    </option>

                                    <option
                                        value="Actividad"
                                        {{ old('tipo_publicacion') === 'Actividad' ? 'selected' : '' }}
                                    >
                                        Actividad
                                    </option>

                                    <option
                                        value="Informacion"
                                        {{ old('tipo_publicacion') === 'Informacion' ? 'selected' : '' }}
                                    >
                                        Información
                                    </option>
                                </select>

                                @error('tipo_publicacion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Contenido --}}
                        <div class="mt-3">

                            <label for="contenido" class="form-label fw-semibold">
                                Contenido
                                <span class="text-danger">*</span>
                            </label>

                            <textarea
                                class="form-control rounded-3 @error('contenido') is-invalid @enderror"
                                id="contenido"
                                name="contenido"
                                rows="7"
                                placeholder="Cuéntale a la comunidad tu historia, consejo o experiencia..."
                                required
                            >{{ old('contenido') }}</textarea>

                            @error('contenido')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text">
                                Asegurate que tu publicación sea clara, respetuosa
                                y útil para la comunidad.
                            </div>

                        </div>

                    </div>


                    {{-- Fotografía --}}
                    <div class="mb-4">

                        <h2 class="h5 fw-bold text-primary mb-3">
                            <i class="bi bi-image me-2"></i>
                            Fotografía
                        </h2>

                        <div class="border rounded-4 p-4 bg-light">

                            <label for="fotografia" class="form-label fw-semibold">
                                Agregar fotografía
                            </label>

                            <input
                                type="file"
                                class="form-control rounded-3 @error('fotografia') is-invalid @enderror"
                                id="fotografia"
                                name="fotografia"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            @error('fotografia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Formatos permitidos: JPG, JPEG, PNG o WEBP.
                                Tamaño máximo: 4 MB.
                            </div>

                        </div>

                    </div>


                    {{-- Confirmación --}}
                    <div class="border rounded-4 p-3 mb-4">

                        <div class="form-check">

                            <input
                                class="form-check-input @error('confirmar_informacion') is-invalid @enderror"
                                type="checkbox"
                                id="confirmar_informacion"
                                name="confirmar_informacion"
                                value="1"
                                {{ old('confirmar_informacion') ? 'checked' : '' }}
                                required
                            >

                            <label
                                class="form-check-label"
                                for="confirmar_informacion"
                            >
                                Confirmo que la información suministrada
                                es correcta y puede ser compartida con
                                la comunidad PetRescue.
                            </label>

                            @error('confirmar_informacion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Acciones --}}
                    <div class="d-flex flex-column flex-sm-row gap-3">

                        <button
                            type="submit"
                            class="btn btn-pet-primary rounded-pill px-4 py-2"
                        >
                            <i class="bi bi-send-fill me-2"></i>
                            Publicar
                        </button>

                        <a
                            href="{{ route('comunidad.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-4 py-2"
                        >
                            <i class="bi bi-x-circle me-2"></i>
                            Cancelar
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</section>
@endsection