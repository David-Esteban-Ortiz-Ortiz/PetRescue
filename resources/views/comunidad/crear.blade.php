@extends('layouts.app')

@section('title', 'Compartir publicación | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="pet-form">

                <div class="mb-4">
                    <span class="badge text-bg-primary rounded-pill mb-2">
                        HU5
                    </span>

                    <h1 class="h3 fw-bold mb-1">
                        Compartir una publicación
                    </h1>

                    <p class="text-secondary mb-0">
                        Comparte un consejo, historia, experiencia,
                        actividad o información relacionada con mascotas.
                    </p>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-tools me-2"></i>
                    <strong>Formulario en construcción.</strong>
                    La lógica de guardado se conectará en los próximos días.
                </div>

                <form
                    action="{{ route('comunidad.guardar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="mb-3">
                        <label for="nombre_autor" class="form-label">
                            Nombre del autor
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="nombre_autor"
                            name="nombre_autor"
                            value="{{ old('nombre_autor') }}"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="titulo" class="form-label">
                            Título
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="titulo"
                            name="titulo"
                            value="{{ old('titulo') }}"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="tipo_publicacion" class="form-label">
                            Tipo de publicación
                            <span class="text-danger">*</span>
                        </label>
                        <select
                            class="form-select"
                            id="tipo_publicacion"
                            name="tipo_publicacion"
                            required
                        >
                            <option value="">Seleccione una opción</option>
                            <option value="Consejo">Consejo</option>
                            <option value="Historia">Historia</option>
                            <option value="Experiencia">Experiencia</option>
                            <option value="Actividad">Actividad</option>
                            <option value="Informacion">Información</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="contenido" class="form-label">
                            Contenido
                            <span class="text-danger">*</span>
                        </label>
                        <textarea
                            class="form-control"
                            id="contenido"
                            name="contenido"
                            rows="6"
                            required
                        >{{ old('contenido') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="fotografia" class="form-label">
                            Fotografía
                        </label>
                        <input
                            type="file"
                            class="form-control"
                            id="fotografia"
                            name="fotografia"
                            accept=".jpg,.jpeg,.png,.webp"
                        >
                        <div class="form-text">
                            Formatos permitidos: JPG, JPEG, PNG o WEBP. Máximo 4 MB.
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="confirmar_informacion"
                            name="confirmar_informacion"
                            value="1"
                            required
                        >
                        <label
                            class="form-check-label"
                            for="confirmar_informacion"
                        >
                            Confirmo que la información es correcta.
                        </label>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <button
                            type="submit"
                            class="btn btn-pet-primary"
                        >
                            <i class="bi bi-send-fill me-1"></i>
                            Publicar
                        </button>

                        <a
                            href="{{ route('comunidad.index') }}"
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
