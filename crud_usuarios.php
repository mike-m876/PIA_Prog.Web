<?php
//FORZAR LOGIN Y SESIONES
require_once 'includes/config.php';
require_login();

//INCLUDES
include 'includes/usuarios/usuarios_view.php';
include 'includes/usuarios/usuarios_model.php';
include 'includes/dbh.php';

//ARREGLO GET_USUARIOS
$datos = get_usuarios($pdo);
$usuarios = $datos['usuarios'];
$page = $datos['page'];
$total_pages = $datos['total_pages'];

//ROLES
$estados = get_estados($pdo);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Gestión de usuarios</title>
    <link href="CSS - Estilos/crud_usuarios.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-4">

    <h2>GESTIÓN DE USUARIOS</h2>
    <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] === 3): ?>
        <div class="mb-3">
            <a href="menu_admin.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Director
            </a>
        </div>
    <?php endif; ?>

    <div id="infoAlumno" class="mb-3 d-none">
        <strong>Matrícula:</strong> <span id="infoMatricula"></span><br />
        <strong>Nombre:</strong> <span id="infoNombre"></span>
    </div>

    <table class="table table-bordered" id="tablaCalificaciones">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>CURP</th>
                <th>Nombre completo</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha de registro</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php new_row($usuarios) ?>
        </tbody>
    </table>

    <div class="pagination d-flex justify-content-center align-items-center my-4">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-outline-primary mx-1">&laquo; Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" 
            class="btn mx-1 <?= $i === $page ? 'btn-primary' : 'btn-outline-primary' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-outline-primary mx-1">Siguiente &raquo;</a>
        <?php endif; ?>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modal_editar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarLabel">Editar Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" action="includes/usuarios/usuarios.php" method="POST">
                    <input type="hidden" name="matricula" id="matricula" value="">
                    <label for="id_estado" class="form-label">Estado del usuario</label>
                    <select id="id_estado" name="id_estado" class="form-select" required>
                        <option value="" selected disabled>Seleccionar estado...</option>
                        <?php foreach ($estados as $estado): ?>
                            <option value="<?= htmlspecialchars($estado['id_estado']) ?>">
                                <?= htmlspecialchars($estado['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="activo" class="form-label">Activar/Desactivar usuario</label>
                    <select id="activo" name="activo" class="form-select" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" name="edit_user" value="Guardar cambios">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/crud_cal.js"></script>
    <script>
        function fill_editar_usuario(matricula){
            document.getElementById("matricula").value = matricula;
        }
    </script>
</body>
</html>