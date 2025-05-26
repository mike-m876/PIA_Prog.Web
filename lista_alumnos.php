<?php
require_once 'includes/config.php';
require_login();

require_once 'includes/dbh.php';
include 'includes/alumnos_grupos/alumnos_grupos_model.php';

$id_grupo = isset($_GET['id_grupo']) ? (int)$_GET['id_grupo'] : 0;
$grupos = get_grupo($pdo);
$lista_alumnos = $id_grupo ? get_alumnos_grupo($pdo, $id_grupo) : [];
$alumnos_disponibles = get_alumnos($pdo);



//IMPRIMIENDO MENSAJES
$success_message = $_SESSION['success_message'] ?? null;
$error_message = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<?php if ($success_message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
<?php endif; ?>

<?php if ($error_message): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'DIRECTOR'): ?>
<div class="mb-3">
    <a href="menu_admin.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Director
    </a>
</div>
<?php endif; ?> 

<form method="GET" action="lista_alumnos.php" class="mb-3">
    <label class="form-label">Seleccione un Grupo</label>
    <div class="d-flex gap-2">
        <select name="id_grupo" class="form-select" required>
            <option value="">-- Seleccione un grupo --</option>
            <?php foreach ($grupos as $grupo): ?>
                <option value="<?= $grupo['id_grupo'] ?>" <?= $grupo['id_grupo'] == $id_grupo ? 'selected' : '' ?>>
                    <?= htmlspecialchars($grupo['nombre_grupo']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Ver</button>
    </div>
</form>

<?php if ($id_grupo): ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarAlumno">Añadir Alumno</button>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Matrícula</th>
            <th>Nombre Completo</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($lista_alumnos) === 0): ?>
            <tr><td colspan="3">No hay alumnos en este grupo.</td></tr>
        <?php else: ?>
            <?php foreach ($lista_alumnos as $alumno): ?>
                <tr>
                    <td><?= htmlspecialchars($alumno['id_usuario']) ?></td>
                    <td><?= htmlspecialchars($alumno['nombre_completo']) ?></td>
                    <td>
                        <form method="POST" action="includes/alumnos_grupos/alumnos_grupos.php" onsubmit="return confirm('¿Estás seguro de quitar al alumno del grupo?');">
                            <input type="hidden" name="id_alumno" value="<?= $alumno['id_usuario'] ?>">
                            <input type="hidden" name="id_grupo" value="<?= $id_grupo ?>">
                            <button type="submit" name="quitar_alumno" class="btn btn-danger btn-sm">Quitar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- Modal Agregar Alumno -->
<div class="modal fade" id="modalAgregarAlumno" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="includes/alumnos_grupos/alumnos_grupos.php" class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Agregar Alumno al Grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_grupo" value="<?= $id_grupo ?>">
                <label class="form-label">Seleccionar Alumno</label>
                <select name="id_alumno" class="form-select" required>
                    <option value="">-- Seleccione --</option>
                    <?php foreach ($alumnos_disponibles as $alumno): ?>
                        <option value="<?= $alumno['id_usuario'] ?>">
                            <?= htmlspecialchars($alumno['nombre_completo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" name="add_alumno" class="btn btn-success">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>