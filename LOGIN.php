<?php
require_once 'includes/config.php';
require_once 'includes/dbh.php';
require_once 'includes/login/login_view.php';
require_once 'includes/login/login_model.php';
$roles = get_roles($pdo);
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
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!--ESTILO GENERAL-->
    <link href="CSS - Estilos/Estilos - Home.css" rel="stylesheet">
    <!--ESTILO INDIVIDUAL-->
    <link href="CSS - Estilos/LOGIN.css" rel="stylesheet">
</head>
<body>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="Home.php">
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
                <form action="includes/login/login.php" id="login_form" method="POST">    
                  <!--SELECTOR DE ROl-->
                  <label for= "id_rol" class="mb-3" required>Elegir rol de usuario: </label>
                  <select id="id_rol" name="id_rol" class="form-select mb-3" required>
                    <option value="" selected disabled>Elegir...</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= htmlspecialchars((int)($rol['id_rol'] ?? '')) ?>">
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
                  <div class="form-group mt-3 position-relative">
                    <label>Contraseña</label>
                    <input type="password" placeholder="Ingrese su contraseña" class="form-control" name="psswd" id="psw">
                      <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword()" tabindex="-1" style="background: none; border: none;">
                        <i id="toggleIcon" class="bi bi-eye-fill"></i>
                      </button>
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
              
    <script src="JS/psswrd.js"></script>
    <script src="JS/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>