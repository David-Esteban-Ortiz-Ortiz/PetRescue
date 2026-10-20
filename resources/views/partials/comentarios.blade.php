<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white rounded-4 shadow-sm p-4 p-md-5">
    <h3 class="h5 fw-bold mb-3">Comentarios</h3>

    <!-- Lista de comentarios (luego Juliana conectará esto) -->
    <div class="mb-4">
        <p class="text-secondary small mb-2">
            Aún no hay comentarios. ¡Sé el primero!
        </p>
    </div>

    <!-- Formulario para comentar -->
    
<form action="{{ isset($publicacion)
    ? route('comentarios.publicacion.guardar', $publicacion->id)
    : route('comentarios.reporte.guardar', $reporte->id) }}"
    method="POST" class="pet-form bg-light">
        @csrf

        <!-- ID dinámico: depende de dónde se incluya -->
        <input type="hidden" name="publicacion_id"
               value="{{ $publicacion->id ?? '' }}">

        <input type="hidden" name="reporte_id"
               value="{{ $reporte->id ?? '' }}">

        <div class="mb-3">
            <label class="form-label">Escribe tu comentario</label>

            <textarea name="contenido" class="form-control"
                      rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-pet-secondary btn-sm">
            Enviar comentario
        </button>
        </form>
            </div>
        </div>
    </div>
</div>
