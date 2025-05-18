<?php
include('../dbh.php');
include('../config.php');
require_login();
session_start();

// Verificar rol de administrador/director
if ($_SESSION['id_rol'] != 1) { // Asumiendo que 1 es el ID del rol director
    $_SESSION['mensaje'] = "No tienes permisos para esta acción";
    $_SESSION['tipo'] = "danger";
    header("Location: turnos.php");
    exit();
}

$nombre = trim($_POST['nombre']);

// Validar duplicado usando prepared statement
$stmt = $pdo->prepare("SELECT * FROM turnos WHERE nombre = ?");
$stmt->execute([$nombre]);

if ($stmt->rowCount() > 0) {
    $_SESSION['mensaje'] = "El turno ya existe.";
    $_SESSION['tipo'] = "danger";
} else {
    // Insertar usando prepared statement
    try {
        $stmt = $pdo->prepare("INSERT INTO turnos (nombre) VALUES (?)");
        $stmt->execute([$nombre]);
        
        $_SESSION['mensaje'] = "Turno agregado exitosamente.";
        $_SESSION['tipo'] = "success";
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al agregar turno: " . $e->getMessage();
        $_SESSION['tipo'] = "danger";
    }
}

header("Location: turnos.php");
?>