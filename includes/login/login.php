<?php

session_start();

if($_SERVER ["REQUEST_METHOD"] == "POST" && isset($_POST['login_button'])) {
    //DECLARACIÓN DE VARIABLES
    $id_rol = (int) $_POST["id_rol"];
    $matricula = (int) $_POST["matricula"];
    $psswd = $_POST["psswd"];

    try {
        require_once '../dbh.php';
        require 'login_model.php';
        require 'login_view.php';
        require 'Login_contr.php';

        //MANEJO DE ERRORES
        $errors = [];

        if (is_input_empty($matricula, $psswd, $id_rol)) {
            $errors["empty_input"] = "Todos los campos deben ser llenados"; 
        }

        $user = get_user($pdo, $matricula, $id_rol);
        
        if (is_matricula_wrong($user)) {
            $errors["login_error"] = "Credenciales incorrectas";
        } else if (is_psswd_wrong($psswd, $user["psswd_hash"])) {
            $errors["login_error"] = "Credenciales incorrectas";
        }

        require_once '../config.php';

        //GUARDADO E IMPRESIóN DE ERRORES
        if ($errors) {
            $_SESSION ["errors_login"] = $errors;

            header('Location:../../LOGIN.php');
            die();
        }

        //SUPONIENDO NINGÚN ERROR
        $new_session_id = session_create_id(true);
        $session_id = $new_session_id . "_" . $user["id_usuario"];
        session_id($session_id);

        $_SESSION["nom_usuario"] = htmlspecialchars($user["nom_usuario"] ?? '');
        $_SESSION["user_id"] = $user["id_usuario"];
        $_SESSION["last_regeneration"] = time();

        //DIRECCIÓN A MENÚS
        switch ($id_rol) {
            case 1:
                header("Location: ../../menu_alumno.php");
                break;
            case 2:
                header("Location: ../../menu_maestro.php");
                break;
            case 3:
                header("Location: ../../menu_admin.php");
                break;
            default:
                header("Location: ../../login.php");
                break;
        }

        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../Home.php");
    exit;
}