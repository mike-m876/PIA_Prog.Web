<?php

require_once 'includes/config.php';
require_login();

?>

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
        <div class="container d-flex justify-content-between align-items-center">
            <!-- IZQUIERDA -->
            <a class="navbar-brand" href="#">Alumno</a>
            <!-- CENTRO -->
            <div class="text-center">
                <strong><?= htmlspecialchars($_SESSION['nom_usuario']) ?></strong><br>
                <small>Matrícula:  <?= htmlspecialchars($_SESSION["matricula"]) ?></small>
            </div>
            <!-- DERECHA -->
            <button class="btn btn-light">
                <i class="bi bi-key"></i> ¿Olvidaste tu contraseña?
            </button>
        </div>
    </nav>

    <div class="contenido-principal d-flex justify-content-center align-items-center">
        <a href="calificaciones_alumnos.php" class="btn btn-outline-primary btn-lg px-5 py-4 text-center">
            <i class="bi bi-journal-check fs-1 d-block mb-2"></i>
            Calificaciones
        </a>
    </div>

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