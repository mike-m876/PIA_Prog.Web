<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="CSS - Estilos/menu_alumno.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Alumno</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuAlumno">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuAlumno">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalContrasena">Cambiar
                            Contraseña</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Botón de calificaciones -->
    <div class="contenido-principal d-flex justify-content-center align-items-center">
        <a href="#" class="btn btn-outline-primary btn-lg px-5 py-4 text-center">
            <i class="bi bi-journal-check fs-1 d-block mb-2"></i>
            Calificaciones
        </a>
    </div>

    <!-- Modal Cambiar Contraseña -->
    <div class="modal fade" id="modalContrasena" tabindex="-1" aria-labelledby="modalContrasenaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCambiarContrasena">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalContrasenaLabel"><i class="bi bi-lock-fill me-2"></i>Cambiar
                            Contraseña</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="actual" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" id="actual" required>
                        </div>
                        <div class="mb-3">
                            <label for="nueva" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="nueva" required minlength="12">
                        </div>
                        <div class="mb-3">
                            <label for="confirmar" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirmar" required minlength="12">
                            <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/mn_alm_val.js"></script>
</body>

</html>