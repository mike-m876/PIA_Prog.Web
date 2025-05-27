<?php

require_once 'includes/config.php';
require_login();

include 'includes/dbh.php';
include 'includes/calificaciones/calificaciones_model.php';
include 'includes/calificaciones/calificaciones_view.php';

$results = get_mater_grupo($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_materia'], $_POST['id_grupo'])) {
    $id_grupo = $_POST['id_grupo'];
    $id_materia = $_POST['id_materia'];

    $alumnos = get_calificaciones($pdo, $id_materia, $id_grupo);
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
    <h1 class="text-center mb-4">Gestión de Calificaciones</h1>

    <?php
    if (!empty($_SESSION['errors_calificaciones'])) {
        echo '<div class="alert alert-danger">';
        foreach ($_SESSION['errors_calificaciones'] as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
        unset($_SESSION['errors_calificaciones']);
    }

    if (!empty($_SESSION['success_calificaciones'])) {
        echo '<div class="alert alert-success">';
        echo htmlspecialchars($_SESSION['success_calificaciones']);
        echo '</div>';
        unset($_SESSION['success_calificaciones']);
    }
    ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Kardex Asignado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php new_row_grupos($results); ?>
        </tbody>
    </table>


<div class="modal fade" id="modal_editar" tabindex="-1" aria-labelledby="modalCalifsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form method="POST" action="includes/calificaciones/calificaciones.php">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCalifsLabel">
            Calificaciones
          </h5>
          <a href="" class="btn-close" aria-label="Cerrar"></a>
        </div>
        <div class="modal-body">
          <!-- Campos ocultos -->
          <table class="table table-bordered table-striped justify-content-center">
            <thead class="table-dark">
              <tr>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Promedio</th>
                <th>Parcial 1</th>
                <th>Parcial 2</th>
              </tr>
            </thead>
            <tbody>
              <?php new_row_califs($alumnos); ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="submit" name="edit_califs" class="btn btn-success">Guardar Cambios</button>
        </div>
        <input type="hidden" name="id_grupo" id="id_grupo" value="<?= htmlspecialchars($id_grupo ?? '') ?>">
         <input type="hidden" name="id_materia" id="id_materia" value="<?= htmlspecialchars($id_materia ?? '') ?>">
      </form>
    </div>
  </div>
</div>

<?php if (!empty($alumnos)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('modal_editar'));
        modal.show();
    });
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!--CARGAR IDs GRUPO_MATERIA -->
<script>
  function cargar_grupo_materia(id_grupo, id_materia) {
      document.getElementById('id_grupo').value = id_grupo;
      document.getElementById('id_materia').value = id_materia;
  }

  function cat_materias(parcial1, parcial2){

  }
</script>
</body>
</html>
