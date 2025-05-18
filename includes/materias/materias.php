<?php 
include('../dbh.php'); 
include('../config.php');
require_login();

// Verificar rol de director
if ($_SESSION['id_rol'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Función para mostrar mensajes 
function mostrar_mensaje() {
    if (!empty($_SESSION['mensaje'])) {
        $tipo = $_SESSION['tipo'] ?? 'success'; 
        echo '<div class="alert alert-'.$tipo.' alert-dismissible fade show" role="alert">';
        echo $_SESSION['mensaje'];
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        
        // Limpiar el mensaje después de mostrarlo
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']); 
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>CRUD Materias</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  </head>
  <body class="bg-light">
  <div class="container mt-5">
      <h2 class="mb-4"><i class="bi bi-book"></i> Gestión de Materias</h2>
      
      <?php mostrar_mensaje(); ?>

      <!-- Botón agregar -->
      <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">
          <i class="bi bi-plus-circle"></i> Nueva Materia
      </button>

      <!-- Tabla de materias -->
      <div class="table-responsive">
          <table class="table table-bordered table-hover bg-white">
              <thead class="table-light">
                  <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Maestro Asignado</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      $stmt = $pdo->query("
                          SELECT m.*, u.nombres as maestro_nombre, u.apellido_pat as maestro_apellido 
                          FROM materias m
                          LEFT JOIN usuarios u ON m.id_maestro = u.id_usuario
                          ORDER BY m.nombre ASC
                      ");
                      
                      while ($row = $stmt->fetch()):
                  ?>
                  <tr>
                      <td><?= htmlspecialchars($row['id_materia']) ?></td>
                      <td><?= htmlspecialchars($row['nombre']) ?></td>
                      <td><?= htmlspecialchars($row['desc_materia']) ?></td>
                      <td>
                          <?= $row['maestro_nombre'] ? htmlspecialchars($row['maestro_nombre'].' '.$row['maestro_apellido']) : 'Sin asignar' ?>
                      </td>
                      <td>
                          <button class="btn btn-warning btn-sm editar-btn" 
                                  data-id="<?= $row['id_materia'] ?>"
                                  data-nombre="<?= htmlspecialchars($row['nombre'], ENT_QUOTES) ?>"
                                  data-desc="<?= htmlspecialchars($row['desc_materia'], ENT_QUOTES) ?>"
                                  data-maestro="<?= $row['id_maestro'] ?>">
                              <i class="bi bi-pencil"></i> Editar
                          </button>
                          <button class="btn btn-danger btn-sm eliminar-btn" 
                                  data-id="<?= $row['id_materia'] ?>"
                                  data-nombre="<?= htmlspecialchars($row['nombre'], ENT_QUOTES) ?>">
                              <i class="bi bi-trash"></i> Eliminar
                          </button>
                      </td>
                  </tr>
                  <?php 
                      endwhile;
                  } catch (PDOException $e) {
                      $_SESSION['mensaje'] = "Error al cargar las materias: " . $e->getMessage();
                      $_SESSION['mensaje_tipo'] = 'danger';
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>

  <!-- Modal Agregar -->
  <div class="modal fade" id="modalAgregar" tabindex="-1">
      <div class="modal-dialog">
          <form action="insertar.php" method="POST" class="modal-content">
              <div class="modal-header bg-success text-white">
                  <h5 class="modal-title">Nueva Materia</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label class="form-label">Nombre</label>
                      <input type="text" name="nombre" class="form-control" placeholder="Nombre de la materia" required>
                  </div>
                  
                  <div class="mb-3">
                      <label class="form-label">Descripción</label>
                      <textarea name="desc_materia" class="form-control" placeholder="Descripción (opcional)"></textarea>
                  </div>
                  
                  <div class="mb-3">
                      <label class="form-label">Maestro asignado</label>
                      <select name="id_maestro" class="form-select">
                          <option value="">-- Seleccionar maestro --</option>
                          <?php
                          try {
                              $maestros = $pdo->query("SELECT id_usuario, nombres, apellido_pat FROM usuarios WHERE id_rol = 2 ORDER BY nombres");
                              foreach ($maestros as $m):
                          ?>
                              <option value="<?= htmlspecialchars($m['id_usuario']) ?>">
                                  <?= htmlspecialchars($m['nombres'].' '.$m['apellido_pat']) ?>
                              </option>
                          <?php 
                              endforeach;
                          } catch (PDOException $e) {
                              echo '<option value="">Error al cargar maestros</option>';
                          }
                          ?>
                      </select>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-success">Agregar</button>
              </div>
          </form>
      </div>
  </div>

  <!-- Modal Editar (único modal dinámico) -->
  <div class="modal fade" id="modalEditar" tabindex="-1">
      <div class="modal-dialog">
          <form action="actualizar.php" method="POST" class="modal-content">
              <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title">Editar Materia</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id_materia" id="edit-id">
                  
                  <div class="mb-3">
                      <label class="form-label">Nombre</label>
                      <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                  </div>
                  
                  <div class="mb-3">
                      <label class="form-label">Descripción</label>
                      <textarea name="desc_materia" id="edit-desc" class="form-control"></textarea>
                  </div>
                  
                  <div class="mb-3">
                      <label class="form-label">Maestro asignado</label>
                      <select name="id_maestro" id="edit-maestro" class="form-select">
                          <option value="">-- Seleccionar maestro --</option>
                          <?php
                          try {
                              $maestros = $pdo->query("SELECT id_usuario, nombres, apellido_pat FROM usuarios WHERE id_rol = 2 ORDER BY nombres");
                              foreach ($maestros as $m):
                          ?>
                              <option value="<?= htmlspecialchars($m['id_usuario']) ?>">
                                  <?= htmlspecialchars($m['nombres'].' '.$m['apellido_pat']) ?>
                              </option>
                          <?php 
                              endforeach;
                          } catch (PDOException $e) {
                              echo '<option value="">Error al cargar maestros</option>';
                          }
                          ?>
                      </select>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </div>
          </form>
      </div>
  </div>

  <!-- Modal Eliminar -->
  <div class="modal fade" id="modalEliminar" tabindex="-1">
      <div class="modal-dialog">
          <form action="eliminar.php" method="GET" class="modal-content">
              <div class="modal-header bg-danger text-white">
                  <h5 class="modal-title">Eliminar Materia</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  ¿Estás seguro de eliminar la materia <strong id="eliminar-nombre"></strong>?
                  <input type="hidden" name="id" id="eliminar-id">
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-danger">Eliminar</button>
              </div>
          </form>
      </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../JS/materias.js"></script>
  </body>
</html>