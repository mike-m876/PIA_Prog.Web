<?php

require_once 'includes/config.php';
require_login();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="CSS - Estilos/menu_alumno.css" rel="stylesheet">
</head>

<body>
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- IZQUIERDA -->
            <a class="navbar-brand" href="#">Alumno</a>
            <!-- CENTRO -->
            <div class="text-center">
                <strong><?= htmlspecialchars($_SESSION['nom_usuario']) ?></strong><br>
                <small>Matrícula:  <?= htmlspecialchars($_SESSION["matricula"]) ?></small>
            </div>
        </div>
    </nav>

    <div class="contenido-principal d-flex justify-content-center align-items-center">
        <a href="calificaciones_alumnos.php" class="btn btn-outline-primary btn-lg px-5 py-4 text-center">
            <i class="bi bi-journal-check fs-1 d-block mb-2"></i>
            Calificaciones
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/psswrd.js"></script>
    <script src="JS/mn_alm_val.js"></script>
</body>

</html>