<?php

declare(strict_types=1);

session_start();

require_once '../dbh.php';
include 'grupos_model.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_grupo'])) {
    $id_nivel = (int) $_POST['nivel'];
    $id_aula = (int) $_POST['aula'];
    $id_ciclo = (int) $_POST['ciclo'];
    $id_turno = (int) $_POST['turno'];
    $id_maestro = (int) $_POST['maestro'];

    $errors = [];

    if($errors){
        $_SESSION["errors_grupos"] = $errors;
        header('Location: ../../crud_grupos.php');
        die();
    }

    crear_grupo($pdo, $id_nivel, $id_aula, $id_ciclo, $id_turno, $id_maestro);
    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_grupos.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_grupo'])) {
    $id_grupo = (int) $_POST['grupo'];
    $id_nivel = (int) $_POST['nivel'];
    $id_aula = (int) $_POST['aula'];
    $id_ciclo = (int) $_POST['ciclo'];
    $id_turno = (int) $_POST['turno'];
    $id_maestro = (int) $_POST['maestro'];

    $errors = [];

    if($errors){
        $_SESSION["errors_materias"] = $errors;
        header('Location: ../../crud_materias.php');
        die();
    }

    edit_grupo($pdo, $id_grupo, $id_nivel, $id_aula, $id_ciclo, $id_turno, $id_maestro);
    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_grupos.php');
    exit();
}

if (isset($_POST['delete_grupo'])) {
    $id_grupo = (int)$_POST['grupo_eliminar'];
    delete_grupo($pdo, $id_grupo);
    header("Location: ../../crud_grupos.php");
    exit;
}