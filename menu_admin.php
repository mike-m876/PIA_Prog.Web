<?php
require_once 'includes/config.php';
require_login();
require_role(3)

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="CSS - Estilos/menu_admin.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-danger">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- IZQUIERDA -->
            <a class="navbar-brand" href="#">Administrador</a>
            <!-- CENTRO -->
            <div class="text-center text-white">
                <?= htmlspecialchars($_SESSION['nom_usuario']) ?><br>
                <small>Matrícula:  <?= htmlspecialchars($_SESSION["matricula"]) ?></small>
            </div>
        </div>
    </nav>


    <div class="botones-grid">
        <!-- Botón de Gestión de Usuarios -->
        <div class="boton-admin">
            <a href="crud_usuarios.php" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-people-fill fs-1 d-block mb-2"></i>
                Gestión de Usuarios
            </a>
        </div>
    
        <!-- Botón de Carga de Calificaciones -->
        <div class="boton-admin">
            <a href="crud_calificaciones.php" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-journal-check fs-1 d-block mb-2"></i>
                Calificaciones
            </a>
        </div>
    
        <!-- Botón de Materias -->
        <div class="boton-admin">
            <a href="crud_materias.php" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-book fs-1 d-block mb-2"></i>
                Materias
            </a>
        </div>
    
        <!-- Botón de Grupos -->
        <div class="boton-admin">
            <a href="crud_grupos.php" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-collection fs-1 d-block mb-2"></i>
                Grupos
            </a>
        </div>
    
        <!-- Botón de Turnos -->
        <div class="boton-admin">
            <a href="crud_turnos.php" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-clock fs-1 d-block mb-2"></i>
                Turnos
            </a>
        </div>
    
        <!-- Botón de Reporte Estadístico -->
        <div class="boton-admin">
            <a href="reportes_ciclos.php" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-graph-up fs-1 d-block mb-2"></i>
                Reporte Estadístico
            </a>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/psswrd.js"></script>
    <script src="JS/mn_adm.js"></script>
</body>
</html>