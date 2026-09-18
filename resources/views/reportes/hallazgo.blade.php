@extends('layouts.app')

@section('title', 'Reportar mascota encontrada | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-xl-9">

            <div class="pet-form">

                <div class="d-flex align-items-center gap-3 mb-4">

                    <img
                        src="{{ asset('images/icono-petrescue.png') }}"
                        alt="Icono de PetRescue"
                        width="85"
                        height="85"
                    >

                    <div>
                        <span class="badge badge-found rounded-pill mb-2">
                            HU2
                        </span>

                        <h1 class="h2 fw-bold mb-1">
                            Reportar mascota encontrada
                        </h1>

                        <p class="text-secondary mb-0">
                            Registra las características de la mascota y
                            la información relacionada con el hallazgo.
                        </p>
                    </div>

                </div>

                <div class="progress mb-4" style="height: 8px;">
                    <div
                        class="progress-bar bg-primary"
                        role="progressbar"
                        style="width: 100%;"
                        aria-valuenow="100"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('reportes.hallazgo.guardar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="mb-5">

                        <h2 class="h5 fw-bold mb-3">
                            <i class="bi bi-heart-fill text-primary me-2"></i>
                            Información de la mascota encontrada
                        </h2>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">
                                    Tipo de mascota
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    class="form-select"
                                    id="tipo"
                                    name="tipo"
                                    required
                                >
                                    <option value="">Seleccione una opción</option>
                                    <option value="Perro" {{ old('tipo') == 'Perro' ? 'selected' : '' }}>Perro</option>
                                    <option value="Gato" {{ old('tipo') == 'Gato' ? 'selected' : '' }}>Gato</option>
                                    <option value="Otro" {{ old('tipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="raza" class="form-label">
                                    Raza aproximada
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="raza"
                                    name="raza"
                                    value="{{ old('raza') }}"
                                    placeholder="Ejemplo: Labrador o mestizo"
                                    maxlength="100"
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label">
                                    Color principal
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="color"
                                    name="color"
                                    value="{{ old('color') }}"
                                    placeholder="Ejemplo: Negro y blanco"
                                    maxlength="100"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tamano" class="form-label">
                                    Tamaño aproximado
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    class="form-select"
                                    id="tamano"
                                    name="tamano"
                                    required
                                >
                                    <option value="">Seleccione una opción</option>
                                    <option value="Pequeno" {{ old('tamano') == 'Pequeno' ? 'selected' : '' }}>Pequeño</option>
                                    <option value="Mediano" {{ old('tamano') == 'Mediano' ? 'selected' : '' }}>Mediano</option>
                                    <option value="Grande" {{ old('tamano') == 'Grande' ? 'selected' : '' }}>Grande</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sexo" class="form-label">
                                    Sexo
                                </label>

                                <select
                                    class="form-select"
                                    id="sexo"
                                    name="sexo"
                                >
                                    <option value="">Seleccione una opción</option>
                                    <option value="Macho" {{ old('sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
                                    <option value="Hembra" {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                                    <option value="No identificado" {{ old('sexo') == 'No identificado' ? 'selected' : '' }}>No identificado</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edad_aproximada" class="form-label">
                                    Edad aproximada
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="edad_aproximada"
                                    name="edad_aproximada"
                                    value="{{ old('edad_aproximada') }}"
                                    placeholder="Ejemplo: 2 años"
                                    maxlength="50"
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado_fisico" class="form-label">
                                    Estado físico general
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    class="form-select"
                                    id="estado_fisico"
                                    name="estado_fisico"
                                    required
                                >
                                    <option value="">Seleccione una opción</option>
                                    <option value="Bueno" {{ old('estado_fisico') == 'Bueno' ? 'selected' : '' }}>Se encuentra en buen estado</option>
                                    <option value="Herido" {{ old('estado_fisico') == 'Herido' ? 'selected' : '' }}>Presenta heridas</option>
                                    <option value="Requiere atencion" {{ old('estado_fisico') == 'Requiere atencion' ? 'selected' : '' }}>Requiere atención veterinaria</option>
                                    <option value="No identificado" {{ old('estado_fisico') == 'No identificado' ? 'selected' : '' }}>No se pudo identificar</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fotografia" class="form-label">
                                    Fotografía de la mascota
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="file"
                                    class="form-control"
                                    id="fotografia"
                                    name="fotografia"
                                    accept=".jpg,.jpeg,.png"
                                    required
                                >

                                <div class="form-text">
                                    Formatos permitidos: JPG, JPEG y PNG.
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="caracteristicas" class="form-label">
                                    Características particulares
                                    <span class="text-danger">*</span>
                                </label>

                                <textarea
                                    class="form-control"
                                    id="caracteristicas"
                                    name="caracteristicas"
                                    rows="3"
                                    placeholder="Describe manchas, cicatrices, collar, placa u otras características visibles"
                                    required
                                >{{ old('caracteristicas') }}</textarea>
                            </div>

                        </div>

                    </div>

                    <hr class="mb-5">

                    <div class="mb-5">

                        <h2 class="h5 fw-bold mb-3">
                            <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                            Información del hallazgo
                        </h2>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="fecha_hallazgo" class="form-label">
                                    Fecha del hallazgo
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="fecha_hallazgo"
                                    name="fecha_hallazgo"
                                    value="{{ old('fecha_hallazgo') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="hora_hallazgo" class="form-label">
                                    Hora aproximada
                                </label>

                                <input
                                    type="time"
                                    class="form-control"
                                    id="hora_hallazgo"
                                    name="hora_hallazgo"
                                    value="{{ old('hora_hallazgo') }}"
                                >
                            </div>

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
                                    value="{{ old('ciudad', 'Pasto') }}"
                                    maxlength="100"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="barrio" class="form-label">
                                    Barrio o sector
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="barrio"
                                    name="barrio"
                                    value="{{ old('barrio') }}"
                                    placeholder="Ejemplo: Barrio San Juan"
                                    maxlength="150"
                                    required
                                >
                            </div>

                            <div class="col-12 mb-3">
                                <label for="referencia" class="form-label">
                                    Dirección o punto de referencia
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="referencia"
                                    name="referencia"
                                    value="{{ old('referencia') }}"
                                    placeholder="Ejemplo: Frente al parque principal"
                                    maxlength="255"
                                    required
                                >
                            </div>

                            <div class="col-12 mb-3">
                                <label for="ubicacion_actual" class="form-label">
                                    Lugar donde se encuentra actualmente
                                    la mascota
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="ubicacion_actual"
                                    name="ubicacion_actual"
                                    value="{{ old('ubicacion_actual') }}"
                                    placeholder="Ejemplo: Hogar temporal, veterinaria o refugio"
                                    maxlength="255"
                                    required
                                >
                            </div>

                            <div class="col-12 mb-3">
                                <label for="circunstancias" class="form-label">
                                    Circunstancias del hallazgo
                                    <span class="text-danger">*</span>
                                </label>

                                <textarea
                                    class="form-control"
                                    id="circunstancias"
                                    name="circunstancias"
                                    rows="4"
                                    placeholder="Describe cómo y dónde fue encontrada la mascota"
                                    required
                                >{{ old('circunstancias') }}</textarea>
                            </div>

                        </div>

                    </div>

                    <hr class="mb-5">

                    <div class="mb-4">

                        <h2 class="h5 fw-bold mb-3">
                            <i class="bi bi-person-lines-fill text-primary me-2"></i>
                            Información de quien realiza el reporte
                        </h2>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Proporciona un medio de contacto válido para que
                            el propietario pueda comunicarse contigo.
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
                            Confirmo que la información proporcionada
                            es correcta.
                        </label>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-3">

                        <button
                            type="submit"
                            class="btn btn-pet-secondary"
                        >
                            <i class="bi bi-send-fill me-1"></i>
                            Publicar hallazgo
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
