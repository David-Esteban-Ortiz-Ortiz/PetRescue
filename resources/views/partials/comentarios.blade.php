<div class="mt-5">
    <h3 class="h5 fw-bold mb-4">Comentarios</h3>

    <!-- Lista de comentarios -->
    <div class="mb-4">
        @if(isset($publicacion) && $publicacion->comentarios->count() > 0)
            @foreach($publicacion->comentarios as $comentario)
                <div class="card mb-3 border-0 bg-light rounded-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                {{-- FOTO DE QUIEN COMENTA --}}
                                @if($comentario->user && $comentario->user->avatar)
                                    <img src="{{ asset('storage/' . $comentario->user->avatar) }}" class="rounded-circle border border-2 border-white" width="35" height="35" style="object-fit: cover;">
                                @else
                                    <i class="bi bi-person-circle fs-4 text-primary"></i>
                                @endif
                                <strong class="text-primary">{{ $comentario->nombre_autor }}</strong>
                            </div>
                            <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0 ms-4 ps-2">{{ $comentario->contenido }}</p>
                    </div>
                </div>
            @endforeach
        @elseif(isset($reporte) && $reporte->comentarios->count() > 0)
            @foreach($reporte->comentarios as $comentario)
                <div class="card mb-3 border-0 bg-light rounded-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                {{-- FOTO DE QUIEN COMENTA --}}
                                @if($comentario->user && $comentario->user->avatar)
                                    <img src="{{ asset('storage/' . $comentario->user->avatar) }}" class="rounded-circle border border-2 border-white" width="35" height="35" style="object-fit: cover;">
                                @else
                                    <i class="bi bi-person-circle fs-4 text-primary"></i>
                                @endif
                                <strong class="text-primary">{{ $comentario->nombre_autor }}</strong>
                            </div>
                            <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0 ms-4 ps-2">{{ $comentario->contenido }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-secondary small mb-2">Aún no hay comentarios. ¡Sé el primero en aportar!</p>
        @endif
    </div>

    <!-- Formulario para comentar -->
    @auth
        @if(isset($publicacion))
            <form action="{{ route('comentarios.publicacion.guardar', $publicacion->id) }}" method="POST" class="pet-form bg-light rounded-3 border">
        @elseif(isset($reporte))
            <form action="{{ route('comentarios.reporte.guardar', $reporte->id) }}" method="POST" class="pet-form bg-light rounded-3 border">
        @endif
                @csrf
                <h4 class="h6 fw-bold mb-3">Deja un comentario</h4>
                @if (session('exito'))
                    <div class="alert alert-success py-2">{{ session('exito') }}</div>
                @endif
                <div class="mb-3">
                    <textarea name="contenido" class="form-control" rows="3" placeholder="Escribe tu comentario aquí..." required></textarea>
                </div>
                <button type="submit" class="btn btn-pet-primary btn-sm">
                    <i class="bi bi-send-fill me-1"></i> Publicar comentario
                </button>
            </form>
    @else
        <div class="alert alert-info d-flex align-items-center">
            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
            <div>
                Debes <a href="{{ route('login') }}" class="fw-bold">iniciar sesión</a> para poder comentar.
            </div>
        </div>
    @endauth
</div>
