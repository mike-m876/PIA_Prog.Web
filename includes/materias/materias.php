<?php

declare(strict_types=1);

require_once __DIR__ . '/../dbh.php';

include 'materias_model.php';
include 'materias_view.php';
include 'materias_contr.php';



if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_materia'])){
    //DECLARACIÓN DE VARIABLES
    $nombre = $_POST['nombre'];
    $desc = $_POST['desc_materia'] ?? '';

    //MANEJO DE ERRORES
    $errors = [];

    if(is_input_empty($nombre)){
        $errors['empty_input'] = "Campo de nombre debe ser llenado";
    }

    if(is_materia_registered($pdo, $nombre)){
        $errors['materia_registered'] = "Categoría ya registrada";
    }

    if($errors){
        $_SESSION["errors_materias"] = $errors;
        header('Location: ../../crud_materias.php');
        die();
    }

    //SUPONIENDO NINGÚN ERROR
    nueva_materia($pdo, $nombre, $desc);
    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_materias.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_materia'])) {
    //DECLARACIÓN DE VARIABLES
    $id_materia = (int)$_POST['id_materia'];
    $nombre = $_POST['nombre'];
    $desc_materia = $_POST['desc_materia'] ?? '';

    //MANEJO DE ERRORES
    $errors = [];

    $materias = get_materia_by_id($pdo, $id_materia);
    if(!$materias){
        $errors["wrong materia"] = "Materia no encontrada";
    }

    if(is_input_empty($nombre)){
        $errors['empty_input'] = "Campo de nombre debe ser llenado";
    }

    $materia_original = get_materia_by_id($pdo, $id_materia);
    if($materia_original && $materia_original['nombre'] !== $nombre && is_materia_registered($pdo, $nombre)){
        $errors['materia_registered'] = "Materia ya registrada";
    }

    if($errors){
        $_SESSION["errors_materias"] = $errors;
        header('Location: ../../crud_materias.php');
        die();
    }

    //SUPONIENDO NINGÚN ERROR    
    edit_materia($pdo, $id_materia, $nombre, $desc_materia);
    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_materias.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_materia'])) {
    $id_materia = (int)$_POST['id_materia'];

    //MANEJO DE ERRORES
    $errors = [];
    $materias = get_materia_by_id($pdo, $id_materia);
    if(!$materias){
        $errors["wrong materia"] = "Materia no encontrada";
    }

    if($errors){
        $_SESSION["errors_materias"] = $errors;
        header('Location: ../../crud_materias.php');
        die();
    }

    //SUPONIENDO NINGÚN ERROR    
    delete_materia($pdo, $id_materia);
    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_materias.php');
    exit();
}