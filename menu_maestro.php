<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú Maestro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS propio -->
    <link rel="stylesheet" href="CSS - Estilos/menu_maestro.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Maestro</a>
            <div class="collapse navbar-collapse" id="menuMaestro">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalContrasena">Cambiar
                            Contraseña</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#" id="btnCerrarSesion">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Botón central: Subir Calificaciones -->
    <div class="contenido-principal d-flex justify-content-center align-items-center">
        <a href="subir_calificaciones.html" class="btn btn-outline-success btn-lg px-5 py-4 text-center">
            <i class="bi bi-upload fs-1 d-block mb-2"></i>
            Subir Calificaciones
        </a>
    </div>

    <!-- Modal Cambiar Contraseña -->
    <div class="modal fade" id="modalContrasena" tabindex="-1" aria-labelledby="modalContrasenaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCambiarContrasena">
                    <div class="modal-header bg-dark text-white">
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
                            <input type="password" class="form-control" id="nueva" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="confirmar" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirmar" required minlength="6">
                            <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/mn_mto.js"></script>
</body>

</html>