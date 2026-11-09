@extends('layouts.app')

@section('title', 'Editar Mascota | PetRescue')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="pet-form">
                <h1 class="h3 fw-bold mb-4">Editar Mascota: {{ $mascota->nombre }}</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mascotas.actualizar', $mascota->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nombre de la mascota *</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $mascota->nombre) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo *</label>
                        <select name="tipo" class="form-select" required>
                            <option value="Perro" {{ old('tipo', $mascota->tipo) == 'Perro' ? 'selected' : '' }}>Perro</option>
                            <option value="Gato" {{ old('tipo', $mascota->tipo) == 'Gato' ? 'selected' : '' }}>Gato</option>
                            <option value="Otro" {{ old('tipo', $mascota->tipo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Raza</label>
                        <input type="text" name="raza" class="form-control" value="{{ old('raza', $mascota->raza) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Color principal *</label>
                        <input type="text" name="color_principal" class="form-control" value="{{ old('color_principal', $mascota->color_principal) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tamaño *</label>
                        <select name="tamano" class="form-select" required>
                            <option value="Pequeno" {{ old('tamano', $mascota->tamano) == 'Pequeno' ? 'selected' : '' }}>Pequeño</option>
                            <option value="Mediano" {{ old('tamano', $mascota->tamano) == 'Mediano' ? 'selected' : '' }}>Mediano</option>
                            <option value="Grande" {{ old('tamano', $mascota->tamano) == 'Grande' ? 'selected' : '' }}>Grande</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Características particulares *</label>
                        <textarea name="caracteristicas_particulares" class="form-control" rows="3" required>{{ old('caracteristicas_particulares', $mascota->caracteristicas_particulares) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fotografía (Opcional si no deseas cambiarla)</label>
                        <input type="file" name="fotografia" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <button type="submit" class="btn btn-pet-primary">Actualizar Mascota</button>
                    <a href="{{ route('mascotas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
