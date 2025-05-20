<?php
session_start();
require_once '../dbh.php';
require_once 'alumnos_grupos_model.php';

function redirect_with_message($url, $success = null, $error = null)
{
    if ($success) $_SESSION['success_message'] = $success;
    if ($error) $_SESSION['error_message'] = $error;
    header("Location: $url");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_alumno'])) {
    $id_alumno = (int) $_POST['id_alumno'];
    $id_grupo = (int) $_POST['id_grupo'];

    if ($id_alumno > 0 && $id_grupo > 0) {
        add_alumnos($pdo, $id_alumno, $id_grupo);
        redirect_with_message("../../lista_alumnos.php?id_grupo=$id_grupo", "Alumno agregado correctamente");
    } else {
        redirect_with_message("../../lista_alumnos.php?id_grupo=$id_grupo", null, "Datos inválidos");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quitar_alumno'])) {
    $id_alumno = (int) $_POST['id_alumno'];
    $id_grupo = (int) $_POST['id_grupo'];

    if ($id_alumno > 0 && $id_grupo > 0) {
        quitar_alumno($pdo, $id_alumno, $id_grupo);
        redirect_with_message("../../lista_alumnos.php?id_grupo=$id_grupo", "Alumno quitado correctamente");
    } else {
        redirect_with_message("../../lista_alumnos.php?id_grupo=$id_grupo", null, "Datos inválidos");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_grupo'])) {
    $id_grupo = (int) $_POST['grupo'];
    $nivel = (int) $_POST['nivel'];
    $aula = (int) $_POST['aula'];
    $ciclo = (int) $_POST['ciclo'];
    $turno = (int) $_POST['turno'];
    $maestro = (int) $_POST['maestro'];

    if ($id_grupo && $nivel && $aula && $ciclo && $turno && $maestro) {
        edit_grupo($pdo, $id_grupo, $nivel, $aula, $ciclo, $turno, $maestro);
        redirect_with_message("../../lista_alumnos.php?id_grupo=$id_grupo", "Grupo editado correctamente");
    } else {
        redirect_with_message("../../lista_alumnos.php?id_grupo=$id_grupo", null, "Faltan datos para editar el grupo");
    }
}
