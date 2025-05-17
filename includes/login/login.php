<?php

session_start();

if($_SERVER ["REQUEST_METHOD"] == "POST") {
    //DECLARACIÓN DE VARIABLES
    $id_rol = (int) $_POST["id_rol"];
    $matricula = (int) $_POST["matricula"];
    $password = $_POST["password"];

    try {
        require_once 'dbh.php';
        require 'login_model.php';
        require 'login_view.php';
        require 'Login_contr.php';

        //MANEJO DE ERRORES
        $errors = [];

        if (is_input_empty($matricula, $password, $id_rol)) {
            $errors["empty_input"] = "Todos los campos deben ser llenados"; 
        }

        $result = get_user($pdo, $matricula);
        
        if (is_matricula_wrong($result)) {
            $errors["mat_wrong"] = "Matrícula incorrecta";
        } else if(is_psswd_wrong($psswd, $result["psswd_hash"])){
            $errors["psswd_wrong"] = "Contraseña incorrecta";
        }
        require_once '../config.php';

        //GUARDADO E IMPRESIóN DE ERRORES
        if ($errors) {
            $_SESSION ["errors_login"] = $errors;

            header('Location:../../LOGIN.php');
            die();
        }

        //SUPONIENDO NINGÚN ERROR
        $new_session_id = session_create_id();
        $session_id = $new_session_id . "_" . $result["id_usuario"];
        session_id($session_id);

        $_SESSION["nom_usuario"] = htmlspecialchars($result["nom_usuario"]);
        $_SESSION["user_id"] = $result["id_usuario"];
        $_SESSION["last_regeneration"] = time();

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