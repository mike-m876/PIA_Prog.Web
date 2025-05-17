<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/login/login_view.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <!--BOOTSTRAP-->
    <link href="CSS - Estilos/bootstrap.css" rel="stylesheet">
    <!--ESTILO GENERAL-->
    <link href="CSS - Estilos/Estilos - Home.css" rel="stylesheet">
    <!--ESTILO INDIVIDUAL-->
    <link href="CSS - Estilos/LOGIN.css" rel="stylesheet">
</head>
<body>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="Home.html">
            <img src="Imagenes/home-button.png" alt="Home" style="width: 40px; height: 40px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="Nosotros.php">Nosotros</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="Contacto.php">Contacto</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="Registro.php">Registro</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="LOGIN.php">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="Oferta.php">Oferta Educativa</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="container h-100">
        <div class="row mt-4 justify-content-center h-100">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-primary text-white"> 
                <h1 class="h4 mb-0">Iniciar Sesión</h1> 
              </div>
              <div class="card-body">
                <form action="includes/login/login.php" id="login_form">    
                  <!--SELECTOR DE ROl-->
                  <label for= "slc_rol" class="mb-3">Elegir rol de usuario: </label>
                  <select id="id_rol" name="id_rol" form="registro_form">
                    <option value="" selected disabled>Elegir...</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= htmlspecialchars((string)($rol['id_rol'] ?? '')) ?>">
                            <?= htmlspecialchars((string)($rol['nombre'] ?? 'Sin nombre')) ?>
                        </option>
                    <?php endforeach; ?>
                  </select>
                  <!--INGRESO DE MATRÍCULA -->
                  <div class="form-group">
                    <label>Matrícula</label>
                    <input type="text" placeholder="Ingrese su matrícula" class="form-control" name="matricula">
                  </div>
                  <!-- INGRESO DE CONTRASEÑA-->
                  <div class="form-group mt-3">
                    <label>Contraseña</label>
                    <input type="password" placeholder="Ingrese su contraseña" class="form-control" name="psswd">
                  </div>
                  <?php check_login_errors(); ?>
                  <input type="submit" class="btn btn-primary mt-3" name="login_button">
                </form>
              </div>
              <div class="card-footer text-end"> 
              </div>
            </div>
          </div>
        </div>
      </div>

    <script src="JS/bootstrap.js"></script>
</body>
</html>