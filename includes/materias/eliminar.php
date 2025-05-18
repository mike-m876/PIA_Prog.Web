<?php
include("../dbh.php");
session_start();

$id = $_GET['id'];
$conn->query("DELETE FROM materias WHERE id_materia = $id");

$_SESSION['mensaje'] = "Materia eliminada correctamente.";
$_SESSION['tipo'] = "success";

header("Location: materias.php");
