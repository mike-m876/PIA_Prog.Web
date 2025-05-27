<?php

require_once 'includes/config.php';
require_login();

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú Maestro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS - Estilos/menu_maestro.css">
</head>

<body>
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- IZQUIERDA -->
            <a class="navbar-brand" href="#">Maestro</a>
            <!-- CENTRO -->
            <div class="text-center text-white">
                <strong><?= htmlspecialchars($_SESSION['nom_usuario']) ?></strong><br>
                <small>Matrícula:  <?= htmlspecialchars($_SESSION["matricula"]) ?></small>
            </div>
        </div>
        <div>
            <a href="cerrar_sesion.php" class="btn btn-outline-light btn-sm">
                <i class=""bi bi-box-arrow-rigth></i>Cerrar Sesión
            </a>
        </div>
    </nav>

    <div class="contenido-principal d-flex justify-content-center align-items-center">
        <a href="crud_calificaciones.php" class="btn btn-outline-success btn-lg px-5 py-4 text-center">
            <i class="bi bi-upload fs-1 d-block mb-2"></i>
            Subir Calificaciones
        </a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/psswrd.js"></script>
    <script src="JS/mn_mto.js"></script>
</body>

</html>