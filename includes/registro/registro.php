<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../dbh.php';
require 'registro_model.php';
require 'registro_view.php';
require 'registro_contr.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //DECLARACIÓN DE VARIABLES
    $id_rol = isset($_POST['id_rol']) ? (int) $_POST['id_rol'] : 0;
    if ($id_rol <= 0) {
        die("Error: Debes seleccionar un rol válido.");
    }    
    $nombres = $_POST["nombre"];
    $apellido_pat = $_POST["apellido_pat"];
    $apellido_mat = $_POST["apellido_mat"];
    $telefono = $_POST["telefono"];
    $curp = $_POST["curp"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //MANEJO DE ERRORES
    $errors = [];

    if (is_input_empty($curp, $nombres, $apellido_pat, $apellido_mat,
    $telefono, $email, $password, $id_rol)) {
        $errors["empty_input"] = "Todos los campos deben ser llenados"; 
    }

    $result = get_curp($pdo, $curp);
    if (is_curp_registered($pdo, $curp)) {
        $errors["curp_used"] = "CURP ya registrada";
    }
    
    if (is_email_invalid($email)) {
        $errors["invalid_email"] = "Correo electrónico inválido";
    }

    if(!is_valid_rol($pdo, $id_rol)){
        $errors["invalid_role"] = "Rol inválido";
    }

    if ($errors) {
        $_SESSION ["errors_registro"] = $errors;
        header ('Location: ../../Registro.php');
        die();
    }

    //SUPONIENDO NINGÚN ERROR
    create_user($pdo, $curp, $nombres, $apellido_pat, $apellido_mat,
        $telefono, $email, $password, $id_rol);    
    $pdo = null;
    $stmt = null;
    header("Location: /PIA_Prog.Web/login.php");
    die();
} else {
    header("Location: /PIA_Prog.Web/Registro.php");
    exit;
}