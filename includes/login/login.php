<?php

if($_SERVER ["REQUEST_METHOD"] == "POST") {
    
    $id_rol = (int) $_POST["id_rol"];
    $id_usuario = (int) $_POST["matricula"];
    $password = $_POST["password"];

    try {
        require_once 'dbh.php';
        require_once 'login_model.php';
        require_once 'Login_contr.php';

        //MANEJO DE ERRORES
        $errors = [];

        if (is_input_empty($id_usuario, $password, $id_rol)) {
            $errors["empty_input"] = "Todos los campos deben ser llenados"; 
        }

        $result = get_user($pdo, $id_usuario);

        if (is_matricula_wrong($result)) {
            $errors["login_incorrecto"] = "Matrícula de usuario no encontrada";
        }

        if (!is_matricula_wrong($result) && is_psswd_wrong($password, $result["psswd_hash"])) {
            $errors["login_incorrecto"] = "Contraseña incorrecta";
        }

        require_once 'config.php';

        if ($errors) {
            $_SESSION ["errors_signup"] = $errors;

            header ('Location: ../Registro.html');
            die();
        }


        header("Location: ../Registro.php?signup=success");

        $pdo = null;
        $stmt = null;
        
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../Home.html");
    exit;
}