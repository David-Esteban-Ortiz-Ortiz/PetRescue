@extends('layouts.app')

@section('title', 'Registrar Mascota | PetRescue')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="pet-form">
                <h1 class="h3 fw-bold mb-4">Registrar nueva mascota</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- El enctype es obligatorio para subir fotos --}}
                <form action="{{ route('mascotas.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nombre de la mascota *</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo *</label>
                        <select name="tipo" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Perro" {{ old('tipo') == 'Perro' ? 'selected' : '' }}>Perro</option>
                            <option value="Gato" {{ old('tipo') == 'Gato' ? 'selected' : '' }}>Gato</option>
                            <option value="Otro" {{ old('tipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Raza</label>
                        <input type="text" name="raza" class="form-control" value="{{ old('raza') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Color principal *</label>
                        <input type="text" name="color_principal" class="form-control" value="{{ old('color_principal') }}" required>
                    </div>

                    {{-- NUEVO CAMPO: TAMAÑO --}}
                    <div class="mb-3">
                        <label class="form-label">Tamaño *</label>
                        <select name="tamano" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Pequeno" {{ old('tamano') == 'Pequeno' ? 'selected' : '' }}>Pequeño</option>
                            <option value="Mediano" {{ old('tamano') == 'Mediano' ? 'selected' : '' }}>Mediano</option>
                            <option value="Grande" {{ old('tamano') == 'Grande' ? 'selected' : '' }}>Grande</option>
                        </select>
                    </div>

                    {{-- NUEVO CAMPO: CARACTERÍSTICAS PARTICULARES --}}
                    <div class="mb-3">
                        <label class="form-label">Características particulares *</label>
                        <textarea name="caracteristicas_particulares" class="form-control" rows="3" placeholder="Ejemplo: Tiene una mancha en el ojo izquierdo, collar rojo..." required>{{ old('caracteristicas_particulares') }}</textarea>
                    </div>

                    {{-- CAMPO DE FOTOGRAFÍA --}}
                    <div class="mb-3">
                        <label class="form-label">Fotografía de la mascota</label>
                        <input type="file" name="fotografia" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-text">Formatos permitidos: JPG, JPEG, PNG o WEBP. Tamaño máximo: 4 MB.</div>
                    </div>

                    <button type="submit" class="btn btn-pet-primary">Guardar Mascota</button>
                    <a href="{{ route('mascotas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
