@extends('layouts.app')

@section('title', 'Reportar mascota perdida | PetRescue')

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
                        <span class="badge badge-loss rounded-pill mb-2">
                            HU1
                        </span>

                        <h1 class="h2 fw-bold mb-1">
                            Reportar mascota perdida
                        </h1>

                        <p class="text-secondary mb-0">
                            Completa la información para publicar el reporte
                            de pérdida.
                        </p>
                    </div>

                </div>

                <div class="progress mb-4" style="height: 8px;">
                    <div
                        class="progress-bar bg-warning"
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
                    action="{{ route('reportes.perdida.guardar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="mb-5">

                        <h2 class="h5 fw-bold mb-3">
                            <i class="bi bi-heart-fill text-danger me-2"></i>
                            Información de la mascota
                        </h2>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="nombre_mascota" class="form-label">
                                    Nombre de la mascota
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nombre_mascota"
                                    name="nombre_mascota"
                                    value="{{ old('nombre_mascota') }}"
                                    placeholder="Ejemplo: Lulu"
                                    maxlength="100"
                                    required
                                >
                            </div>

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
                                    Raza
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="raza"
                                    name="raza"
                                    value="{{ old('raza') }}"
                                    placeholder="Ejemplo: Labrador"
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
                                    placeholder="Ejemplo: Dorado"
                                    maxlength="100"
                                    required
                                >
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tamano" class="form-label">
                                    Tamaño
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    class="form-select"
                                    id="tamano"
                                    name="tamano"
                                    required
                                >
                                    <option value="">Seleccione</option>
                                    <option value="Pequeno" {{ old('tamano') == 'Pequeno' ? 'selected' : '' }}>Pequeño</option>
                                    <option value="Mediano" {{ old('tamano') == 'Mediano' ? 'selected' : '' }}>Mediano</option>
                                    <option value="Grande" {{ old('tamano') == 'Grande' ? 'selected' : '' }}>Grande</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="sexo" class="form-label">
                                    Sexo
                                </label>

                                <select
                                    class="form-select"
                                    id="sexo"
                                    name="sexo"
                                >
                                    <option value="">Seleccione</option>
                                    <option value="Macho" {{ old('sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
                                    <option value="Hembra" {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                                    <option value="Desconocido" {{ old('sexo') == 'Desconocido' ? 'selected' : '' }}>Desconocido</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="edad_aproximada" class="form-label">
                                    Edad aproximada
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="edad_aproximada"
                                    name="edad_aproximada"
                                    value="{{ old('edad_aproximada') }}"
                                    placeholder="Ejemplo: 3 años"
                                    maxlength="50"
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="identificacion" class="form-label">
                                    Placa o microchip
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="identificacion"
                                    name="identificacion"
                                    value="{{ old('identificacion') }}"
                                    placeholder="Número o información disponible"
                                    maxlength="150"
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fotografia" class="form-label">
                                    Fotografía de la mascota
                                </label>

                                <input
                                    type="file"
                                    class="form-control"
                                    id="fotografia"
                                    name="fotografia"
                                    accept=".jpg,.jpeg,.png"
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
                                    placeholder="Describe manchas, cicatrices, color del collar u otras características"
                                    required
                                >{{ old('caracteristicas') }}</textarea>
                            </div>

                        </div>

                    </div>

                    <hr class="mb-5">

                    <div class="mb-5">

                        <h2 class="h5 fw-bold mb-3">
                            <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                            Información de la pérdida
                        </h2>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="fecha_perdida" class="form-label">
                                    Fecha de pérdida
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="fecha_perdida"
                                    name="fecha_perdida"
                                    value="{{ old('fecha_perdida') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="hora_perdida" class="form-label">
                                    Hora aproximada
                                </label>

                                <input
                                    type="time"
                                    class="form-control"
                                    id="hora_perdida"
                                    name="hora_perdida"
                                    value="{{ old('hora_perdida') }}"
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
                                    placeholder="Ejemplo: Barrio Centro"
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
                                    placeholder="Ejemplo: Cerca al parque principal"
                                    maxlength="255"
                                    required
                                >
                            </div>

                            <div class="col-12 mb-3">
                                <label for="descripcion" class="form-label">
                                    Circunstancias de la pérdida
                                    <span class="text-danger">*</span>
                                </label>

                                <textarea
                                    class="form-control"
                                    id="descripcion"
                                    name="descripcion"
                                    rows="4"
                                    placeholder="Describe brevemente cómo y dónde ocurrió la pérdida"
                                    required
                                >{{ old('descripcion') }}</textarea>
                            </div>

                        </div>

                    </div>

                    <hr class="mb-5">

                    <div class="mb-4">

                        <h2 class="h5 fw-bold mb-3">
                            <i class="bi bi-person-lines-fill text-primary me-2"></i>
                            Información de contacto
                        </h2>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Esta información permitirá que otros usuarios
                            puedan comunicarse contigo si encuentran
                            a la mascota.
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="propietario" class="form-label">
                                    Nombre del propietario
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="propietario"
                                    name="propietario"
                                    value="{{ old('propietario', auth()->user()->name ?? '') }}"
                                    maxlength="150"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">
                                    Número de teléfono
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="tel"
                                    class="form-control"
                                    id="telefono"
                                    name="telefono"
                                    value="{{ old('telefono', auth()->user()->telefono_principal ?? '') }}"
                                    minlength="7"
                                    maxlength="20"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">
                                    Correo electrónico
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="correo"
                                    name="correo"
                                    value="{{ old('correo', auth()->user()->email ?? '') }}"
                                    maxlength="150"
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="medio_contacto" class="form-label">
                                    Medio de contacto preferido
                                </label>

                                <select
                                    class="form-select"
                                    id="medio_contacto"
                                    name="medio_contacto"
                                >
                                    <option value="">Seleccione</option>
                                    <option value="Telefono" {{ old('medio_contacto') == 'Telefono' ? 'selected' : '' }}>Llamada telefónica</option>
                                    <option value="WhatsApp" {{ old('medio_contacto') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="Correo" {{ old('medio_contacto') == 'Correo' ? 'selected' : '' }}>Correo electrónico</option>
                                </select>
                            </div>

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
                            Confirmo que la información suministrada
                            es correcta.
                        </label>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-3">

                        <button
                            type="submit"
                            class="btn btn-pet-primary"
                        >
                            <i class="bi bi-send-fill me-1"></i>
                            Publicar reporte
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
