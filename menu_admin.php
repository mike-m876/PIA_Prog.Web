<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="CSS - Estilos/menu_admin.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger"> 
        <div class="container">
            <a class="navbar-brand" href="#">Administrador</a>
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
                        <a class="nav-link text-dark" href="#">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="botones-grid">
        <!-- Botón de Gestión de Usuarios -->
        <div class="boton-admin">
            <a href="crud_usuarios.php" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-people-fill fs-1 d-block mb-2"></i>
                Gestión de Usuarios
            </a>
        </div>
    
        <!-- Botón de Carga de Calificaciones -->
        <div class="boton-admin">
            <a href="crud_calificaciones.php" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-journal-check fs-1 d-block mb-2"></i>
                Calificaciones
            </a>
        </div>
    
        <!-- Botón de Materias -->
        <div class="boton-admin">
            <a href="#" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-book fs-1 d-block mb-2"></i>
                Materias
            </a>
        </div>
    
        <!-- Botón de Grupos -->
        <div class="boton-admin">
            <a href="#" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-collection fs-1 d-block mb-2"></i>
                Grupos
            </a>
        </div>
    
        <!-- Botón de Turnos -->
        <div class="boton-admin">
            <a href="#" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-clock fs-1 d-block mb-2"></i>
                Turnos
            </a>
        </div>
    
        <!-- Botón de Reporte Estadístico -->
        <div class="boton-admin">
            <a href="#" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-graph-up fs-1 d-block mb-2"></i>
                Reporte Estadístico
            </a>
        </div>

    <!-- Modal Cambiar Contraseña -->
    <div class="modal fade" id="modalContrasena" tabindex="-1" aria-labelledby="modalContrasenaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCambiarContrasena">
                    <div class="modal-header bg-danger text-white">
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
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/mn_adm.js"></script>
</body>
</html>