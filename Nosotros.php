<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS General-->
    <link href="CSS - Estilos/Estilos - Home.css" rel="stylesheet">
    <!-- CSS Individual-->
    <link href="CSS - Estilos/Nosotros.css" rel="stylesheet">

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

    <div class="container">
        <div class="row prim-fila mb-4 img_wrap align-items-center">
            <div class="col-6 Historia">
                <h1>Nuestra historia</h1>
            </div>
            <div class="col-6 Desc">
                <p class="lead">
                    En la Escuela Secundaria MIAU, nos enorgullece ofrecer una educación integral basada en valores, 
                    excelencia académica y desarrollo humano. Nuestro compromiso es formar jóvenes críticos, creativos y comprometidos con su comunidad,
                    preparándolos para los desafíos del futuro en un entorno inclusivo y seguro.
                    <br>
                    Con más de 20 años de experiencia en el ámbito educativo, contamos con un equipo docente altamente calificado, instalaciones modernas 
                    y programas académicos alineados con los estándares de la SEP.
                </p>
            </div>
        </div>
        <div class="row mb-5"> 
        <!-- Sección Visión -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm p-3"> 
                    <img src="Imagenes/vision.jpg" class="card-img-top img-fluid rounded-circle mx-auto d-block" style="width: 100px;" alt="Visión">
                    <div class="card-body text-center">
                        <h3 class="card-title">Visión</h3>
                        <p class="card-text text-justify">
                            Ser reconocidos como la institución líder en educación secundaria en [localidad], destacando por nuestra innovación pedagógica y formación en valores. Nuestros egresados son ciudadanos responsables, preparados para triunfar en sus estudios superiores y en la vida profesional.
                        </p>
                    </div>
                </div>
            </div>
    <!-- Sección Misión -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm p-3">
                <img src="Imagenes/mission.png" class="card-img-top img-fluid rounded-circle mx-auto d-block" style="width: 100px;" alt="Misión">
                <div class="card-body text-center">
                    <h3 class="card-title">Misión</h3>
                    <p class="card-text text-justify">
                        Brindar una educación de calidad que fomente el pensamiento crítico y la creatividad. Promovemos un ambiente de aprendizaje colaborativo con tecnología de vanguardia y un modelo educativo humanista, donde cada estudiante alcanza su máximo potencial.
                    </p>
                </div>
            </div>
        </div>
            <div class="col-4">
                <h3 class="Centrado">Red de valores</h3>
                <a class="valores">
                    <img src="Imagenes/valores.jpg">
                </a>
            </div>
        </div>
    </div>

</body>
</html>