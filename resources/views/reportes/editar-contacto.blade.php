@extends('layouts.app')

@section('title', 'Editar información de contacto | PetRescue')

@section('content')
<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-9 col-lg-7">

            <div class="pet-form">

                <div class="text-center mb-4">

                    <i class="bi bi-pencil-square text-success" style="font-size: 3.5rem;"></i>

                    <h1 class="h3 fw-bold mt-3">
                        Editar información de contacto
                    </h1>

                    <p class="text-secondary mb-0">
                        Modifica los datos de contacto asociados al reporte
                        <strong>{{ $reporte->codigo_reporte }}</strong>.
                    </p>

                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Los cambios quedarán visibles de inmediato en la
                    página principal de PetRescue.
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
                    action="{{ route('reportes.contacto.actualizar', $reporte->codigo_reporte) }}"
                    method="POST"
                    id="formularioEditarContacto"
                >
                    @csrf
                    @method('PUT')

                    <input
                        type="hidden"
                        name="codigo_edicion"
                        value="{{ $codigoEdicion }}"
                    >

                    <div class="mb-3">
                        <label for="nombre_contacto" class="form-label">
                            Nombre completo
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control @error('nombre_contacto') is-invalid @enderror"
                            id="nombre_contacto"
                            name="nombre_contacto"
                            value="{{ old('nombre_contacto', $reporte->nombre_contacto) }}"
                            placeholder="Nombre de quien reporta"
                            maxlength="150"
                            required
                        >

                        @error('nombre_contacto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telefono_contacto" class="form-label">
                            Número de teléfono
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="tel"
                            class="form-control @error('telefono_contacto') is-invalid @enderror"
                            id="telefono_contacto"
                            name="telefono_contacto"
                            value="{{ old('telefono_contacto', $reporte->telefono_contacto) }}"
                            minlength="7"
                            maxlength="20"
                            placeholder="Ejemplo: 3173479670"
                            required
                        >

                        @error('telefono_contacto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="correo_contacto" class="form-label">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            class="form-control @error('correo_contacto') is-invalid @enderror"
                            id="correo_contacto"
                            name="correo_contacto"
                            value="{{ old('correo_contacto', $reporte->correo_contacto) }}"
                            maxlength="150"
                            placeholder="nombre@correo.com"
                        >

                        @error('correo_contacto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="medio_contacto_preferido" class="form-label">
                            Medio de contacto preferido
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('medio_contacto_preferido') is-invalid @enderror"
                            id="medio_contacto_preferido"
                            name="medio_contacto_preferido"
                            required
                        >
                            <option value="">Seleccione una opción</option>

                            <option
                                value="Telefono"
                                {{ old('medio_contacto_preferido', $reporte->medio_contacto_preferido) == 'Telefono' ? 'selected' : '' }}
                            >
                                Llamada telefónica
                            </option>

                            <option
                                value="WhatsApp"
                                {{ old('medio_contacto_preferido', $reporte->medio_contacto_preferido) == 'WhatsApp' ? 'selected' : '' }}
                            >
                                WhatsApp
                            </option>

                            <option
                                value="Correo"
                                {{ old('medio_contacto_preferido', $reporte->medio_contacto_preferido) == 'Correo' ? 'selected' : '' }}
                            >
                                Correo electrónico
                            </option>
                        </select>

                        @error('medio_contacto_preferido')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-3">

                        <button
                            type="submit"
                            class="btn btn-pet-primary flex-fill"
                        >
                            <i class="bi bi-floppy-fill me-1"></i>
                            Guardar cambios
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
