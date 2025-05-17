<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla principal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS de estilos-->
    <link href="CSS - Estilos/Estilos - Home.css" rel="stylesheet">
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
    <!--CARRUSEL-->
    <div id="carouselExampleIndicators" class="carousel slide carousel_full" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="Imagenes/edificio_home.jpg" class="d-block w-100" alt="Edificio">
            </div>
            <div class="carousel-item">
                <img src="Imagenes/escuelita.jpeg" class="d-block w-100" alt="Escuelita">
            </div>
            <div class="carousel-item">
                <img src="Imagenes/secundaria.jpeg" class="d-block w-100" alt="Secundaria">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="row footer_cont">
        <div class="col-12 text-center mt-4 mb-4">
          <h1 class="d-inline-block position-relative display-4">
            <span><b>Colegio MIAU</b></span>
            <small class="text-muted position-absolute footer">Est. 2025</small>
          </h1>
        </div>
    </div>
    <div class="row mt-2 mb-2">
        <div class="col-12 text-center">
            <p class="copyright">Copyright © 2024 Secundaria Miau. Derechos reservados</p>
        </div>
    </div>
    <!-- Scripts (jQuery no es necesario para Bootstrap 5) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>