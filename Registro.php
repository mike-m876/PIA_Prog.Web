<?php

session_start();

include 'includes/registro/registro_view.php';
include 'includes/registro/registro_model.php';
include 'includes/dbh.php';
$roles = get_roles($pdo);

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro</title>
        <link href="CSS - Estilos/bootstrap.css" rel="stylesheet">
        <link href="CSS - Estilos/Estilos - Home.css" rel="stylesheet">
        <link href="CSS - Estilos/Registro.css" rel="stylesheet"> 
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
                    <h1 class="h4 mb-0">Solicitud de registro de usuario</h1> 
                  </div>
                  <div class="card-body">
                    <form action="includes/registro/registro.php" method="POST" id="registro_form">
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
                      <!--NOMBRE(S)-->
                      <div class="form-group mt-2">
                        <input type="text" id="name" placeholder="Nombre(s)" class="form-control" name="nombre">
                      </div>
                      <div class="row">
                        <!-- APELLIDO PATERNO -->
                        <div class="form-group col-md-6 mt-2">
                          <input type="text" id="apellido_pat" placeholder="Apellido Paterno" class="form-control" name="apellido_pat">
                        </div>
                        <!-- APELLIDO MATERNO -->
                        <div class="form-group col-md-6 mt-2">
                          <input type="text" id="apellido_mat" placeholder="Apellido Materno" class="form-control" name="apellido_mat">
                        </div>
                      </div>
                      <div class="row">
                        <!--TELÉFONO-->
                        <div class="form-group col-md-6 mt-2">
                          <input type="tel" id="cel" placeholder="Número telefónico" class="form-control" name="telefono">
                        </div>
                        <!--CURP-->
                        <div class="form-group col-md-6 mt-2">
                          <input type="text" id="curp" placeholder="CURP" class="form-control" name="curp">
                          <p id="mensaje_curp" class="mt-3 mb-0">Escribir en <b>Mayúsculas</b></p>
                        </div>
                      </div>
                      <!--Correo-->
                      <div class="form-group mt-2">
                        <input type="email" id="email" placeholder="Correo electrónico" class="form-control" name="email">
                      </div>
                      <!--Contraseña-->
                      <div class="form-group mt-2">
                        <input type="password" id="psw" placeholder="Contraseña" class="form-control" name="password">
                      </div>
                      <!--Mensaje Requisitos-->
                      <ul id="mensaje_psw" class="mt-3">
                          <li id="length" class="invalid">Contraseña de mínimo 12 caractéres</li>
                          <li id="mayusc" class="invalid">Incluir mayúsculas</li>
                          <li id="minusc" class="invalid">Incluir minúsculas</li>
                          <li id="especial" class="invalid">Incluir mínimo un caracter especial</li>
                      </ul>
                      <?php check_registro_error(); ?>
                      <input type="submit" class="btn btn-primary mt-3" disabled id="reg_button">
                    </form>
                  </div>
                  <div class="card-footer text-end"> 
                  </div>
                </div>
              </div>
            </div>
          </div>
    
        <script src="JS/bootstrap.js"></script>
        <script src="JS/Registro.js"></script>
    </body>
</html>