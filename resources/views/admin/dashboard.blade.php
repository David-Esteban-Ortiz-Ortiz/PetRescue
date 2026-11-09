@extends('layouts.app')

@section('title', 'Panel de Administración | PetRescue')

@section('content')
<section class="container py-5">
    <h1 class="display-6 fw-bold mb-4">Panel de Administración</h1>

    @if(session('exito'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i> {{ session('exito') }}
        </div>
    @endif

    <div class="card pet-card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Publicaciones de la Comunidad</h2>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Estado Actual</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publicaciones as $publicacion)
                    <tr>
                        <td>{{ $publicacion->titulo }}</td>
                        <td>{{ $publicacion->nombre_autor }}</td>
                        <td>
                            @if($publicacion->estado === 'Visible')
                                <span class="badge bg-success">Visible</span>
                            @else
                                <span class="badge bg-secondary">Oculta</span>
                            @endif
                        </td>
                        <td>
                            @if($publicacion->estado === 'Visible')
                                <form action="{{ route('admin.ocultar', ['tipo' => 'publicacion', 'id' => $publicacion->id]) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-eye-slash"></i> Ocultar
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.mostrar', ['tipo' => 'publicacion', 'id' => $publicacion->id]) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button class="btn btn-sm btn-success">
                                        <i class="bi bi-eye"></i> Mostrar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
