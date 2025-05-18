<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../dbh.php';
require 'usuarios_model.php';
require 'usuarios_view.php';
require 'usuarios_contr.php';

try {
    $results = get_usuario($pdo);
} catch (\PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

if($_SERVER["REQUEST_METHOD"] === 'POST' && isset ($_POST['edit_user'])){
    $matricula = (int)$_POST["matricula"];
    $id_estado  = (int)$_POST["id_estado"];
    $activo = (int)$_POST["activo"];

    $errors = [];

    if(is_input_empty($matricula, $id_estado, $activo)){
        $errors["empty_input"] = "Todos los campos deben ser llenados"; 
    }
    
    if($errors){
        $_SESSION["errors_usuarios"] = $errors;
        header('Location: ../../crud_usuarios.php');
        die();
    }

    edit_usuario($pdo, $matricula, $id_estado, $activo);

    //USUARIO ACEPTADO EN EL SISTEMA
    if($activo === 1 && $id_estado === 2){
        $user = get_user_by_id($pdo, $matricula);

        if($user){
            $email = $user['email'];
            $nombre = $user['nombres'];
            $id_usuario = $user['id_usuario'];
        }

        $to = $email;
        $subject = "¡Tu cuenta ha sido activada!";
        $message = "Hola $nombre,\n\nTu registro cuenta ha sido aceptado. Tu matrícula es: $id_usuario.\n\n¡Bienvenid@!";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    }

    //USUARIO RECHAZADO
    if($id_estado === 3){
        $user = get_user_by_id($pdo, $matricula);

        if($user){
            $email = $user['email'];
            $nombre = $user['nombres'];
            $id_usuario = $user['id_usuario'];
        }

        $to = $email;
        $subject = "¡Tu cuenta ha sido activada!";
        $message = "Hola $nombre,\n\nTu cuenta ha sido rechazada.";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    }
    
    //CUENTA DESACTIVADA
    if($activo === 0){
        $user = get_user_by_id($pdo, $matricula);

        if($user){
            $email = $user['email'];
            $nombre = $user['nombres'];
            $id_usuario = $user['id_usuario'];
        }

        $to = $email;
        $subject = "¡Tu cuenta ha sido activada!";
        $message = "Hola $nombre,\n\nTu cuenta ha sido desactivada.";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    }

    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_usuarios.php');
} else {
    header ('Location: ../../login.php');
    exit;
}