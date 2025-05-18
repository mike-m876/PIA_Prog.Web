<?php
include('../dbh.php');
include('../config.php');
require_login();
session_start();

if ($_SESSION['id_rol'] != 1) {
    $_SESSION['mensaje'] = "No tienes permisos para esta acción";
    $_SESSION['tipo'] = "danger";
    header("Location: turnos.php");
    exit();
}

$id = $_GET['id'];

try {
    // Verificar si el turno está en uso
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM grupo WHERE id_turno = ?");
    $stmt->execute([$id]);
    $enUso = $stmt->fetchColumn();
    
    if ($enUso > 0) {
        $_SESSION['mensaje'] = "No se puede eliminar: El turno está asignado a uno o más grupos.";
        $_SESSION['tipo'] = "warning";
    } else {
        // Eliminar turno
        $stmt = $pdo->prepare("DELETE FROM turnos WHERE id_turno = ?");
        $stmt->execute([$id]);
        
        $_SESSION['mensaje'] = "Turno eliminado correctamente.";
        $_SESSION['tipo'] = "success";
    }
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al eliminar: " . $e->getMessage();
    $_SESSION['tipo'] = "danger";
}

header("Location: turnos.php");
?>