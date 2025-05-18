<?php
include("../dbh.php");
session_start();

$nombre = trim($_POST['nombre']);
$desc = trim($_POST['desc_materia']);

// Validar duplicado
$res = $conn->query("SELECT * FROM materias WHERE nombre = '$nombre'");
if ($res->num_rows > 0) {
    $_SESSION['mensaje'] = "Ya existe una materia con ese nombre.";
    $_SESSION['tipo'] = "danger";
} else {
    $res = $conn->query("SELECT MAX(id_materia) AS max_id FROM materias");
    $row = $res->fetch_assoc();
    $new_id = $row['max_id'] + 1;
    $conn->query("INSERT INTO materias (id_materia, nombre, desc_materia) VALUES ($new_id, '$nombre', '$desc')");
    $_SESSION['mensaje'] = "Materia agregada exitosamente.";
    $_SESSION['tipo'] = "success";
}

header("Location: index.php");
