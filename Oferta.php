<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oferta Educativa</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS General-->
    <link href="CSS - Estilos/Estilos - Home.css" rel="stylesheet">
    <!-- CSS Individual-->
    <link href="CSS - Estilos/Oferta.css" rel="stylesheet">
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
    <div class="container mt-4">
        <div class="row justify-content-center mb-5">
            <div class="col-12">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img src="Imagenes/homenaje.JPG" class="d-block w-100 img-princ" alt="Actividades escolares">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Excelencia Educativa</h5>
                                <p>Formando líderes del mañana</p>
                            </div>

        <div class="row mt-3 align-items-center">
            <div class="col-lg-5 col-md-6 seg-fila">
                <h3 class="text-primary">Objetivo Educativo</h3>
                <p class="Desc">Formar estudiantes integrales, mediante una educación de calidad que desarrolle sus competencias académicas, habilidades socioemocionales y valores éticos, preparándolos para el acceso a la educación superior, la vida laboral y una participación activa en la sociedad.</p>
                
                <h3 class="text-primary mt-4">Actividades Complementarias</h3>
                <div class="Desc">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-trophy-fill text-primary me-2"></i> Actividades Deportivas</li>
                        <li class="mb-2"><i class="bi bi-music-note-beamed text-primary me-2"></i> Arte y cultura</li>
                        <li class="mb-2"><i class="bi bi-code-square text-primary me-2"></i> Talleres de programación</li>
                        <li class="mb-2"><i class="bi bi-people-fill text-primary me-2"></i> Voluntariado</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-7 col-md-6 mt-md-0 mt-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="Imagenes/prog_educativo.png" class="card-img-top" alt="Programa Educativo">
                    <div class="card-body">
                        <h5 class="card-title text-center">Nuestro Programa Educativo</h5>
                        <p class="card-text text-center text-muted">Conoce nuestro plan de estudios diseñado para el desarrollo integral de nuestros estudiantes.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-5 seg-fila">
                <h3>Objetivo</h3>
                <p class="Desc">"Formar estudiantes integrales, mediante una educación de calidad que desarrolle sus competencias académicas,
                habilidades socioemocionales y valores éticos, preparándolos para el acceso a la educación superior, la vida laboral y
                una participación activa en la sociedad."</p>
                <h3>Actividades Complementarias</h3>
                <div class="Desc">
                    <ul>
                        <li>Actividades Deportivas</li>
                        <li>Arte y cultura(música, teatro, danza)</li>
                        <li>Talleres de programación</li>
                        <li>Programas de voluntariado comunitario</li>
                    </ul>
                </div>
            </div>
            <div class="col-7">
                <a>
                    <img class="w-100" src="Imagenes/act_extracurriculares.jpg" class="card-img-top" alt="Actividades Deportivas">
                </a>
        <!-- Sección adicional para contacto -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card bg-light border-0">
                    <div class="card-body text-center">
                        <h4 class="card-title">¿Interesado en nuestra oferta educativa?</h4>
                        <p class="card-text">Contáctanos para más información sobre nuestros programas y proceso de admisión.</p>
                        <a href="Contacto.html" class="btn btn-primary px-4">Contáctanos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="JS/bootstrap.js"></script>
</body>
</html>