<?php 
require_once 'includes/config.php';
require_login();

include 'includes/dbh.php';
include 'includes/materias/materias.php';  
require_once 'includes/materias/materias_model.php';

try {
    $datos = get_materias_paginated($pdo);
    $materias = $datos['materias'];
    $page = $datos['page'];
    $total_pages = $datos['total_pages'];
} catch (PDOException $e) {
    die("Error al obtener materias: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Materias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] === 3): ?>
    <div class="mb-3">
        <a href="menu_admin.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Director
        </a>
    </div>
    <?php endif; ?>  
    <h2>Gestión de Materias</h2>

    <?php check_materias_errors();?>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modal_agregar">Nueva Materia +</button>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?= new_row($materias); ?>
        </tbody>
    </table>
</div>

    <div class="pagination d-flex justify-content-center align-items-center my-4">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-outline-primary mx-1">&laquo; Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" 
            class="btn mx-1 <?= $i === $page ? 'btn-primary' : 'btn-outline-primary' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-outline-primary mx-1">Siguiente &raquo;</a>
        <?php endif; ?>
    </div>

<!-- Modal Agregar -->
<div class="modal fade" id="modal_agregar" tabindex="-1">
  <div class="modal-dialog">
    <form action="includes/materias/materias.php" method="POST" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Nueva Materia</h5></div>
      <div class="modal-body">
        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre de la materia" required>
        <textarea name="desc_materia" class="form-control" placeholder="Descripción (opcional)"></textarea>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success" name="nueva_materia">Agregar</button>
      </div>
    </form>
  </div>
</div>

<!--MODAL EDITAR -->
<div class="modal fade" id="modal_editar" tabindex="-1">
  <div class="modal-dialog">
    <form action="includes/materias/materias.php" method="POST" class="modal-content">
    <input type="hidden" name="id_materia" id="edit_id_materia" value="">  
    <div class="modal-header"><h5 class="modal-title">Editar Materia</h5></div>
      <div class="modal-body">
        <input type="text" id="edit_nom_materia" name="nombre" class="form-control mb-2" placeholder="Nombre de la materia" required>
        <textarea name="desc_materia" id="edit_desc_materia" class="form-control" placeholder="Descripción (opcional)"></textarea>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success" name="edit_materia">Agregar</button>
        <button type="submit" class="btn btn-danger" name="delete_materia">Borrar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function fill_editar_materia(id_materia, nombre, desc){
            document.getElementById("edit_id_materia").value = id_materia;
            document.getElementById("edit_nom_materia").value = nombre;
            document.getElementById("edit_desc_materia").value = desc;
        }
</script>
</body>
</html>
