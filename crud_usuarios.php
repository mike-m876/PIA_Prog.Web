<?php

include 'includes/usuarios/usuarios_view.php';
include 'includes/usuarios/usuarios_model.php';
include 'includes/dbh.php';

$result = get_usuario($pdo);
$estados = get_estados($pdo);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Gestión de usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-4">

    <h2>GESTIÓN DE USUARIOS</h2>

    <div class="mb-3">
        <input type="text" id="CURP_search" placeholder="Ingrese la CURP a buscar" class="form-control" maxlength="5" />
    </div>
    <button id="btnBuscar" class="btn btn-primary mb-3">Buscar</button>

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
            <?php new_row($result) ?>
        </tbody>
    </table>

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
                    <label for="id_estado" class="form-label">ID Usuario</label>
                    <select id="id_estado" name="id_estado" class="form-select" required>
                        <option value="" selected disabled>Seleccionar estado...</option>
                        <?php foreach ($estados as $estado): ?>
                            <option value="<?= htmlspecialchars($estado['id_estado']) ?>">
                                <?= htmlspecialchars($estado['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="activo" class="form-label">Estado</label>
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
        function fill_modal_editar(matricula){
            document.getElementById("matricula").value = matricula;
        }
    </script>
</body>
</html>