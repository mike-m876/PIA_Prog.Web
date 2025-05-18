<?php
include('../dbh.php');
session_start();

$id = $_POST['id_turno'];
$nombre = trim($_POST['nombre']);

// Validar duplicado excepto el mismo ID
$valida = $conn->query("SELECT * FROM turnos WHERE nombre = '$nombre' AND id_turno != $id");
if ($valida->num_rows > 0) {
    $_SESSION['mensaje'] = "El nombre ya existe en otro turno.";
    $_SESSION['tipo'] = "danger";
} else {
    $conn->query("UPDATE turnos SET nombre = '$nombre' WHERE id_turno = $id");
    $_SESSION['mensaje'] = "Turno actualizado.";
    $_SESSION['tipo'] = "success";
}

header("Location: turnos.php");
?>
