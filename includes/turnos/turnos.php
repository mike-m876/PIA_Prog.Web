<?php 
include('../dbh.php'); 
include('../config.php');
require_login();

// Verificar rol de director
if ($_SESSION['id_rol'] != 1) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Turnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-clock"></i> Gestión de Turnos</h2>
    
    <?php mostrar_mensaje(); ?>

    <!-- Botón agregar -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">
        <i class="bi bi-plus-circle"></i> Nuevo Turno
    </button>

    <!-- Tabla de turnos -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Turno</th>
                    <th>Grupos Asignados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("
                    SELECT t.*, COUNT(g.id_grupo) as grupos_asignados 
                    FROM turnos t
                    LEFT JOIN grupo g ON t.id_turno = g.id_turno
                    GROUP BY t.id_turno
                    ORDER BY t.nombre ASC
                ");
                
                while ($row = $stmt->fetch()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_turno']) ?></td>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td>
                        <?= $row['grupos_asignados'] ?>
                        <?php if ($row['grupos_asignados'] > 0): ?>
                            <button class="btn btn-info btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#modalGrupos<?= $row['id_turno'] ?>">
                                <i class="bi bi-eye"></i> Ver
                            </button>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $row['id_turno'] ?>">
                            <i class="bi bi-pencil"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar<?= $row['id_turno'] ?>">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                <div class="modal fade" id="modalEditar<?= $row['id_turno'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="actualizar.php" method="POST" class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Editar Turno</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_turno" value="<?= $row['id_turno'] ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Nombre del Turno</label>
                                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($row['nombre']) ?>" required>
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
                <div class="modal fade" id="modalEliminar<?= $row['id_turno'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="eliminar.php" method="GET" class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Eliminar Turno</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de eliminar el turno <strong><?= htmlspecialchars($row['nombre']) ?></strong>?
                                <?php if ($row['grupos_asignados'] > 0): ?>
                                    <div class="alert alert-warning mt-2">
                                        <i class="bi bi-exclamation-triangle"></i> Este turno tiene <?= $row['grupos_asignados'] ?> grupo(s) asignado(s).
                                    </div>
                                <?php endif; ?>
                                <input type="hidden" name="id" value="<?= $row['id_turno'] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Ver Grupos -->
                <?php if ($row['grupos_asignados'] > 0): ?>
                <div class="modal fade" id="modalGrupos<?= $row['id_turno'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">Grupos del Turno <?= htmlspecialchars($row['nombre']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Grupo</th>
                                            <th>Grado</th>
                                            <th>Aula</th>
                                            <th>Maestro Titular</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $grupos = $pdo->prepare("
                                            SELECT g.nombre as grupo, n.nombre as grado, a.nombre as aula, 
                                                   CONCAT(u.nombres, ' ', u.apellido_pat) as maestro
                                            FROM grupo g
                                            JOIN nivel n ON g.id_nivel = n.id_nivel
                                            JOIN aula a ON g.id_aula = a.id_aula
                                            JOIN usuarios u ON g.id_maestro = u.id_usuario
                                            WHERE g.id_turno = ?
                                        ");
                                        $grupos->execute([$row['id_turno']]);
                                        
                                        while ($grupo = $grupos->fetch()):
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($grupo['grupo']) ?></td>
                                            <td><?= htmlspecialchars($grupo['grado']) ?></td>
                                            <td><?= htmlspecialchars($grupo['aula']) ?></td>
                                            <td><?= htmlspecialchars($grupo['maestro']) ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1">
    <div class="modal-dialog">
        <form action="insertar.php" method="POST" class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Nuevo Turno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre del Turno</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Matutino, Vespertino" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>