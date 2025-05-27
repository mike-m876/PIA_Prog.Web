<?php 
require_once 'includes/config.php';
require_login();

include 'includes/dbh.php';
include 'includes/turnos/turnos.php';  

try {
    $turnos = get_turnos($pdo);  
} catch (PDOException $e) {
    die("Error al obtener turnos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Turnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] === 3): ?>
    <div class="mb-3">
        <a href="menu_director.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Director
         </a>
    </div>
    <?php endif; ?>
    <h2>Gestión de turnos</h2>

    <?php check_turnos_errors();?>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modal_agregar">Nueva turno +</button>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?= new_row($turnos); ?>
        </tbody>
    </table>
</div>

<!-- Modal Agregar -->
<div class="modal fade" id="modal_agregar" tabindex="-1">
  <div class="modal-dialog">
    <form action="includes/turnos/turnos.php" method="POST" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Nuevo turno</h5></div>
      <div class="modal-body">
        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre del turno" required>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success" name="nuevo_turno">Agregar</button>
      </div>
    </form>
  </div>
</div>

<!--MODAL EDITAR -->
<div class="modal fade" id="modal_editar" tabindex="-1">
  <div class="modal-dialog">
    <form action="includes/turnos/turnos.php" method="POST" class="modal-content">
    <input type="hidden" name="id_turno" id="edit_id_turno" value="">  
    <div class="modal-header"><h5 class="modal-title">Editar turno</h5></div>
      <div class="modal-body">
        <input type="text" id="edit_nom_turno" name="nombre" class="form-control mb-2" placeholder="Nombre del turno" required>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success" name="edit_turno">Agregar</button>
        <button type="submit" class="btn btn-danger" name="delete_turno">Borrar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function fill_editar_turno(id_turno, nombre){
            document.getElementById("edit_id_turno").value = id_turno;
            document.getElementById("edit_nom_turno").value = nombre;
        }
</script>
</body>
</html>
