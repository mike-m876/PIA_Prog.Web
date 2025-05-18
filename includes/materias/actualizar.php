<?php
include('../dbh.php');
include('../config.php');
require_login();
session_start();

// Verificar rol
if ($_SESSION['id_rol'] != 1) {
    $_SESSION['mensaje'] = "No tienes permisos para esta acción";
    $_SESSION['tipo'] = "danger";
    header("Location: materias.php");
    exit();
}

$id = $_POST['id_materia'];
$nombre = trim($_POST['nombre']);
$desc = trim($_POST['desc_materia']);

try {
    // Validar duplicado
    $stmt = $pdo->prepare("SELECT * FROM materias WHERE nombre = ? AND id_materia != ?");
    $stmt->execute([$nombre, $id]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['mensaje'] = "Ya existe otra materia con ese nombre.";
        $_SESSION['tipo'] = "danger";
    } else {
        // Actualizar materia
        $stmt = $pdo->prepare("UPDATE materias SET nombre = ?, desc_materia = ? WHERE id_materia = ?");
        $stmt->execute([$nombre, $desc, $id]);
        
        $_SESSION['mensaje'] = "Materia actualizada correctamente.";
        $_SESSION['tipo'] = "success";
    }
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al actualizar: " . $e->getMessage();
    $_SESSION['tipo'] = "danger";
}

header("Location: materias.php");
?>