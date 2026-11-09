@extends('layouts.app')

@section('title', 'Mis Mascotas | PetRescue')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Mis Mascotas</h1>
        <a href="{{ route('mascotas.crear') }}" class="btn btn-pet-primary">+ Agregar Mascota</a>
    </div>

    @if (session('exito'))
        <div class="alert alert-success">{{ session('exito') }}</div>
    @endif

    <div class="pet-card bg-white p-4">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Raza</th>
                    <th>Color</th>
                    <th>Acciones</th> {{-- <-- NUEVA COLUMNA --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($mascotas as $mascota)
                    <tr>
                        <td>{{ $mascota->nombre }}</td>
                        <td>{{ $mascota->tipo }}</td>
                        <td>{{ $mascota->raza ?? '-' }}</td>
                        <td>{{ $mascota->color_principal }}</td>
                        <td> {{-- <-- NUEVO BOTÓN --}}
                            <a href="{{ route('mascotas.editar', $mascota->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No tienes mascotas registradas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
