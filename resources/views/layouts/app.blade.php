<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'PetRescue')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/petrescue.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('inicio') }}">
                <img
                    src="{{ asset('images/icono-petrescue.png') }}"
                    alt="PetRescue"
                    class="logo-navbar"
                >
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuPrincipal"
                aria-controls="menuPrincipal"
                aria-expanded="false"
                aria-label="Abrir navegación"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inicio') }}">
                            <i class="bi bi-house-door"></i>
                            Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('comunidad.index') }}">
                            <i class="bi bi-people-fill"></i>
                            Comunidad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reportes.perdida') }}">
                            <i class="bi bi-search"></i>
                            Reportar pérdida
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reportes.hallazgo') }}">
                            <i class="bi bi-geo-alt"></i>
                            Reportar hallazgo
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reportes.actualizar-contacto') }}">
                            <i class="bi bi-pencil-square"></i>
                            Actualizar contacto
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @if (session('exito'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('exito') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"
                ></button>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="footer-petrescue mt-5">
        <div class="container py-4 text-center">
            <img
                src="{{ asset('images/icono-petrescue.png') }}"
                alt="PetRescue"
                class="icono-footer"
            >

            <p class="mb-1 fw-semibold">PetRescue</p>
            <p class="mb-0 small">
                Ayudamos a reunir mascotas con sus familias.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
