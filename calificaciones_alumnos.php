<?php
//REQUIERE LOGIN
require_once 'includes/config.php';
require_login();

//INCLUSIÓN PHP
require_once 'includes/dbh.php';
include 'includes/alumnos_grupos/alumnos_grupos_model.php';

$id_alumno = $_GET['id_usuario'] ?? null;

$calificaciones = [];
$infoAlumno = null;

if ($id_alumno) {
    $calificaciones = get_calificaciones_by_alumno($pdo, $id_alumno);

    $stmt = $pdo->prepare("SELECT id_usuario, CONCAT(nombres, ' ', apellido_pat, ' ', apellido_mat) AS nombre_completo FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id_alumno]);
    $infoAlumno = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificaciones del Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<form method="GET" action="calificaciones_alumnos.php" class="mb-3">
    <label class="form-label">Ingrese Matrícula del Alumno</label>
    <div class="d-flex gap-2">
        <input type="number" name="id_usuario" class="form-control" placeholder="ID de alumno" required>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
</form>

<?php if ($infoAlumno): ?>

    <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] === 1): ?>
        <div class="mb-3">
            <a href="menu_alumno.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Alumno
            </a>
        </div>
    <?php endif; ?>
    <h4 class="mb-3">Calificaciones de: MATRÍCULA: <?= $infoAlumno['id_usuario'] ?></h4>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Materia</th>
                <th>Periodo 1</th>
                <th>Periodo 2</th>
                <th>Promedio</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($calificaciones) === 0): ?>
                <tr><td colspan="4">Este alumno no tiene calificaciones registradas.</td></tr>
            <?php else: ?>
                <?php foreach ($calificaciones as $cal): ?>
                    <tr>
                        <td><?= htmlspecialchars($cal['materia']) ?></td>
                        <td><?= htmlspecialchars($cal['periodo1']) ?></td>
                        <td><?= htmlspecialchars($cal['periodo2']) ?></td>
                        <td><?= htmlspecialchars($cal['promedio']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php elseif ($id_alumno): ?>
    <div class="alert alert-warning">Alumno no encontrado.</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
