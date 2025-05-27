<?php
include '../dbh.php';
include 'calificaciones_model.php';
include 'calificaciones_view.php';

$alumnos = [];
$limit = 10; // filas por página
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_materia'], $_POST['id_grupo'])) {
    $id_grupo = $_POST['id_grupo'];
    $id_materia = $_POST['id_materia'];

    // Guardar valores para mantenerlos visibles después de la paginación
    $_SESSION['id_grupo'] = $id_grupo;
    $_SESSION['id_materia'] = $id_materia;
    
    // Para POST cargamos la página 1
    $page = 1;
    $offset = 0;

    $total = count_calificaciones($pdo, $id_materia, $id_grupo);
    $alumnos = get_calificaciones($pdo, $id_materia, $id_grupo, $limit, $offset);
} elseif (isset($_SESSION['id_materia'], $_SESSION['id_grupo'])) {
    // Para GET paginación con valores guardados
    $id_grupo = $_SESSION['id_grupo'];
    $id_materia = $_SESSION['id_materia'];

    $total = count_calificaciones($pdo, $id_materia, $id_grupo);
    $alumnos = get_calificaciones($pdo, $id_materia, $id_grupo, $limit, $offset);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_califs']) && isset($_POST['id_materia'], $_POST['id_grupo'])){
    $id_grupo = $_POST['id_grupo'];
    $id_materia = $_POST['id_materia'];
    $parcial1 = $_POST['parcial1'] ?? [];
    $parcial2 = $_POST['parcial2'] ?? [];

    $errors = [];

    $ids_alumnos = array_unique(array_merge(array_keys($parcial1), array_keys($parcial2)));

    foreach ($ids_alumnos as $id_alumno) {
        $calif1 = $parcial1[$id_alumno] ?? null;
        $calif2 = $parcial2[$id_alumno] ?? null;

if ($calif1 !== null && $calif1 !== '') {
            if (!is_numeric($calif1) || $calif1 < 0 || $calif1 > 100) {
                $errors[] = "Parcial 1 de alumno con ID $id_alumno debe ser un número entre 0 y 100.";
                continue;
            }
        } else {
            $calif1 = null;
        }

        if ($calif2 !== null && $calif2 !== '') {
            if (!is_numeric($calif2) || $calif2 < 0 || $calif2 > 100) {
                $errors[] = "Parcial 2 de alumno con ID $id_alumno debe ser un número entre 0 y 100.";
                continue;
            }
        } else {
            $calif2 = null;
        }

        if ($calif1 !== null || $calif2 !== null) {
            update_calificaciones($pdo, $id_alumno, $id_materia, $id_grupo, $calif1, $calif2);
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors_calificaciones'] = $errors;
    } else {
        $_SESSION['success_calificaciones'] = "Calificaciones actualizadas correctamente.";
    }

    header('Location: ../../crud_calificaciones.php');
    exit();
}
