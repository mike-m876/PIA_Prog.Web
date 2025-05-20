<?php

declare(strict_types=1);

session_start();



require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();



require_once __DIR__ . '/../dbh.php';
require 'usuarios_model.php';
require 'usuarios_view.php';
require 'usuarios_contr.php';



try {
    $results = get_usuario($pdo);

} catch (\PDOException $e) {
    die("Query failed: " . $e->getMessage());
}


if (!isset($_ENV['MAIL_USERNAME']) || !isset($_ENV['MAIL_PASSWORD'])) {
    error_log('Error: Las variables de correo no están configuradas en .env');
    die('Error de configuración del servidor de correo');
}


function send_email(string $email, string $nombre, string $asunto, string $mensaje): void {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        
        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Director General');
        $mail->addAddress($email, $nombre);

        $mail->isHTML(false);
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;

        $mail->send();
    } catch (Exception $e) {
        error_log("Error al enviar el correo: {$mail->ErrorInfo}");
    }
}

if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['edit_user'])) {
    $matricula = (int)$_POST["matricula"];
    $id_estado = (int)$_POST["id_estado"];
    $activo = (int)$_POST["activo"];

    $errors = [];

    if (empty($_POST["matricula"]) || !isset($_POST["id_estado"], $_POST["activo"])) {
        $errors["empty_input"] = "Todos los campos deben ser llenados";
    }

    if ($errors) {
        $_SESSION["errors_usuarios"] = $errors;
        header('Location: ../../crud_usuarios.php');
        die();
    }

    edit_usuario($pdo, $matricula, $id_estado, $activo);

    $user = get_user_by_id($pdo, $matricula);

    if ($user) {
        $email = $user['email'];
        $nombre = $user['nombres'];
        $id_usuario = $user['id_usuario'];

        if ($activo === 1 && $id_estado === 2) {
            send_email($email, $nombre, "¡Tu cuenta ha sido activada!",
                "Hola $nombre,\n\nTu registro ha sido aceptado. Tu matrícula es: $id_usuario.\n\n¡Bienvenid@!");
        }

        if ($id_estado === 3) {
            send_email($email, $nombre, "Tu cuenta ha sido rechazada",
                "Hola $nombre,\n\nLamentamos informarte que tu cuenta ha sido rechazada.");
        }

        if ($activo === 0) {
            send_email($email, $nombre, "Tu cuenta ha sido desactivada",
                "Hola $nombre,\n\nTu cuenta ha sido desactivada.");
        }
    } else {
        error_log("Usuario con matrícula $matricula no encontrado.");
    }

    $pdo = null;
    $stmt = null;
    header('Location: ../../crud_usuarios.php');
    exit;
} else {
    header('Location: ../../login.php');
    exit;
} 