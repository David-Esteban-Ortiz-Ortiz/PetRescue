@extends('layouts.app')

@section('title', 'Panel de Administración | PetRescue')

@section('content')
<section class="container py-5">

    <h1 class="display-6 fw-bold mb-4">
        Panel de Administración
    </h1>

    @if(session('exito'))
        <div class="alert alert-success">
            {{ session('exito') }}
        </div>
    @endif

    <!-- REPORTES DE MASCOTAS -->
    <div class="card pet-card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Reportes de Mascotas</h2>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Mascota</th>
                        <th>Estado Actual</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reportes as $reporte)
                        <tr>
                            <td>{{ $reporte->tipo_reporte }}</td>

                            <td>
                                {{ $reporte->mascota->nombre ?? 'Sin nombre' }}
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ $reporte->estado }}
                                </span>
                            </td>

                            <td>
                                <form
                                    action="{{ route('admin.ocultar', ['tipo' => 'reporte', 'id' => $reporte->id]) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Ocultar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                No hay reportes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PUBLICACIONES DE LA COMUNIDAD -->
    <div class="card pet-card mb-4">
        <div class="card-header bg-success text-white">
            <h2 class="h5 mb-0">
                Publicaciones de la Comunidad
            </h2>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Estado Actual</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($publicaciones as $publicacion)
                        <tr>
                            <td>{{ $publicacion->titulo }}</td>

                            <td>{{ $publicacion->nombre_autor }}</td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ $publicacion->estado }}
                                </span>
                            </td>

                            <td>
                                <form
                                    action="{{ route('admin.ocultar', ['tipo' => 'publicacion', 'id' => $publicacion->id]) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Ocultar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                No hay publicaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>
@endsection
