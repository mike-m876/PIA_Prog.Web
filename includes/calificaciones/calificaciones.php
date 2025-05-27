<?php
include '../dbh.php';
include 'calificaciones_model.php';
include 'calificaciones_view.php';

$alumnos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_materia'], $_POST['id_grupo'])) {
    $id_grupo = $_POST['id_grupo'];
    $id_materia = $_POST['id_materia'];

    $alumnos = get_calificaciones($pdo, $id_materia, $id_grupo);   
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_califs']) && isset($_POST['id_materia'], $_POST['id_grupo'])){
    $id_grupo = $_POST['id_grupo'];
    $id_materia = $_POST['id_materia'];
    $parcial1 = $_POST['parcial1'] ?? [];
    $parcial2 = $_POST['parcial2'] ?? [];

    $ids_alumnos = array_unique(array_merge(array_keys($parcial1), array_keys($parcial2)));

    foreach ($ids_alumnos as $id_alumno) {
        $calif1 = $parcial1[$id_alumno] ?? null;
        $calif2 = $parcial2[$id_alumno] ?? null;

        if ($calif1 !== null || $calif2 !== null) {
            update_calificaciones($pdo, $id_alumno, $id_materia, $id_grupo, $calif1, $calif2);
        }
    }

    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_calificaciones.php');
    exit();
}