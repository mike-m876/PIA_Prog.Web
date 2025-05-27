<?php

require_once 'includes/config.php';
require_login();

include 'includes/dbh.php';
include 'includes/califs_gen/califs_gen_model.php';
include 'includes/califs_gen/califs_gen_view.php';

$id_grupo = isset($_GET['id_grupo']) ? (int)$_GET['id_grupo'] : 0;
$info_grupo = get_mater_grupo($pdo);

$id_materia = isset($_GET['id_materia']) ? $_GET['id_materia'] : null;

$calificaciones = [];
$mostrar_modal = false;
if ($id_grupo && $id_materia) {
    $calificaciones = get_calificaciones_by_mat_and_grupo($pdo, $id_grupo, $id_materia);
    $mostrar_modal = true;
} 
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-4">
    <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] === 'DIRECTOR'): ?>
    <div class="mb-3">
        <a href="menu_admin.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Director
        </a>
      </div>
      <?php endif; ?> 
      
    <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] === 'MAESTRO'): ?>
    <div class="mb-3">
        <a href="menu_maestro.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Maestro
        </a>
    </div>
    <?php endif; ?> 
    <h1 class="text-center mb-4">Gestión de Calificaciones</h1>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nivel</th>
                <th>Aula</th>
                <th>Ciclo Escolar</th>
                <th>Turno</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php imprimir_tabla_grupos($info_grupo); ?>
        </tbody>
    </table>


<div class="modal fade" id="modal_editar" tabindex="-1" aria-labelledby="modalCalifsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form method="POST" action="includes/califs_gen/califs_gen.php">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCalifsLabel">
            Calificaciones - <?php echo htmlspecialchars($id_materia); ?>
          </h5>
          <a href="tu_pagina.php" class="btn-close" aria-label="Cerrar"></a>
        </div>
        <div class="modal-body">
          <!-- Campos ocultos -->
          <input type="hidden" name="id_grupo" value="<?php echo $id_grupo; ?>">
          <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
          <table class="table table-bordered table-striped">
            <thead class="table-dark">
              <tr>
                <th>Alumno</th>
                <th>Parcial 1</th>
                <th>Parcial 2</th>
                <th>Promedio</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($calificaciones)): ?>
                <?php foreach ($calificaciones as $calif): 
                  $id_alumno = $calif['id_alumno'];
                  $p1 = htmlspecialchars($calif['parcial1']);
                  $p2 = htmlspecialchars($calif['parcial2']);
                  $prom = htmlspecialchars($calif['prom_final']);
                  $nombre = htmlspecialchars($calif['alumno_nombre']);
                ?>
                <tr>
                  <td><?php echo $nombre; ?></td>
                  <td>
                    <input type="number" min="0" max="100" name="parcial1[<?php echo $id_alumno; ?>]" 
                           value="<?php echo $p1; ?>" class="form-control" required>
                  </td>
                  <td>
                    <input type="number" min="0" max="100" name="parcial2[<?php echo $id_alumno; ?>]" 
                           value="<?php echo $p2; ?>" class="form-control" required>
                  </td>
                  <td><?php echo $prom; ?></td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-success">Guardar Cambios</button>
          <a href="tu_pagina.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
