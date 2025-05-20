<?php


declare(strict_types=1);

require_once __DIR__ . '/../dbh.php';

include 'turnos_model.php';
include 'turnos_view.php';
include 'turnos_contr.php';



if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_turno'])){
    //DECLARACIÓN DE VARIABLES
    $nombre = $_POST['nombre'];

    //MANEJO DE ERRORES
    $errors = [];

    if(is_input_empty($nombre)){
        $errors['empty_input'] = "Campo de nombre debe ser llenado";
    }

    if(is_turno_registered($pdo, $nombre)){
        $errors['turno_registered'] = "Turno ya registrado";
    }

    if($errors){
        $_SESSION["errors_turnos"] = $errors;
        header('Location: ../../crud_turnos.php');
        die();
    }

    //SUPONIENDO NINGÚN ERROR
    nuevo_turno($pdo, $nombre);
    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_turnos.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_turno'])) {
    //DECLARACIÓN DE VARIABLES
    $id_turno = (int)$_POST['id_turno'];
    $nombre = $_POST['nombre'];

    //MANEJO DE ERRORES
    $errors = [];

    $turnos = get_turno_by_id($pdo, $id_turno);
    if(!$turnos){
        $errors["wrong turno"] = "Turno no encontrado";
    }

    if(is_input_empty($nombre)){
        $errors['empty_input'] = "Campo de nombre debe ser llenado";
    }

    $turno_original = get_turno_by_id($pdo, $id_turno);
    if($turno_original && $turno_original['nombre'] !== $nombre && is_turno_registered($pdo, $nombre)){
        $errors['turno_registered'] = "Turno ya registrada";
    }

    if($errors){
        $_SESSION["errors_turnos"] = $errors;
        header('Location: ../../crud_turnos.php');
        die();
    }

    //SUPONIENDO NINGÚN ERROR    
    edit_turno($pdo, $id_turno, $nombre);
    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_turnos.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_turno'])) {
    $id_turno = (int)$_POST['id_turno'];

    //MANEJO DE ERRORES
    $errors = [];
    $turnos = get_turno_by_id($pdo, $id_turno);
    if(!$turnos){
        $errors["wrong turno"] = "Turno no encontrado";
    }

    if($errors){
        $_SESSION["errors_turnos"] = $errors;
        header('Location: ../../crud_turnos.php');
        die();
    }

    //SUPONIENDO NINGÚN ERROR    
    delete_turno($pdo, $id_turno);
    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_turnos.php');
    exit();
}