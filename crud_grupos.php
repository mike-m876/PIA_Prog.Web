<?php

require_once 'includes/config.php';
require_login();

include 'includes/grupos/grupos_view.php';
include 'includes/grupos/grupos_model.php';
include 'includes/dbh.php';

$result = get_grupo($pdo);
$niveles = get_nivel($pdo);
$aulas = get_aula($pdo);
$ciclos = get_ciclo($pdo);
$turnos = get_turno($pdo);
$maestros = get_maestro($pdo);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRUPOS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="script.js" defer></script>
</head>

<body class="container mt-4">
    <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] === 'DIRECTOR'): ?>
    <div class="mb-3">
        <a href="menu_admin.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Director
        </a>
    </div>
    <?php endif; ?>
    <h1 class="text-center">GESTIÓN DE GRUPOS</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal_agregar">Agregar Grupo</button>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nivel</th>
                <th>Aula</th>
                <th>Ciclo Escolar</th>
                <th>Turno</th>
                <th>Maestro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php new_row($result) ?> 
        </tbody>
    </table>

    <!-- Modal para Agregar Grupo -->
    <div class="modal fade" id="modal_agregar" tabindex="-1" aria-labelledby="modal_editar_grupo_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_editar_grupo_label">Agregar Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/grupos/grupos.php" method="POST">
                        <div class="mb-3">
                            <label for="edit_nivel" class="form-label">Nivel</label>
                            <select type="text" class="form-control" id="edit_nivel" name="nivel" required>
                                <option value="">Seleccionar nivel...</option>
                                <?php foreach($niveles as $nivel): ?>
                                <option value="<?= htmlspecialchars(($nivel['id_nivel'] ?? '')) ?>">
                                    <?= htmlspecialchars(($nivel['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_aula" class="form-label">Aula</label>
                            <select type="text" class="form-control" id="edit_aula" name="aula" required>
                                <option value="">Seleccionar aula...</option>
                                <?php foreach($aulas as $aula): ?>
                                <option value="<?= htmlspecialchars(($aula['id_aula'] ?? '')) ?>">
                                    <?= htmlspecialchars(($aula['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ciclo" class="form-label">Ciclo Escolar</label>
                            <select type="text" class="form-control" id="edit_ciclo" name="ciclo" required>
                                <option value="">Seleccionar ciclo...</option>
                                <?php foreach($ciclos as $ciclo): ?>
                                <option value="<?= htmlspecialchars(($ciclo['id_ciclo'] ?? '')) ?>">
                                    <?= htmlspecialchars(($ciclo['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_turno" class="form-label">Turno</label>
                            <select type="text" class="form-control" id="edit_turno" name="turno" required>
                                <option value="">Seleccionar turno...</option>
                                <?php foreach($turnos as $turno): ?>
                                <option value="<?= htmlspecialchars(($turno['id_turno'] ?? '')) ?>">
                                    <?= htmlspecialchars(($turno['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="maestro" class="form-label">Maestro</label>
                            <select type="text" class="form-control" id="maestro" name="maestro" required>
                                <option value="">Seleccionar maestro...</option>
                                <?php foreach($maestros as $maestro): ?>
                                <option value="<?= htmlspecialchars(($maestro['id_usuario'] ?? '')) ?>">
                                    <?= htmlspecialchars(($maestro['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" name="add_grupo">Agregar grupo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Grupo -->
    <div class="modal fade" id="modal_editar" tabindex="-1" aria-labelledby="modal_editar_grupo_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_editar_grupo_label">Editar Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/grupos/grupos.php" method="POST">
                        <input type="hidden" name="grupo" id="edit_id_grupo" value="">
                        <div class="mb-3">
                            <label for="edit_nivel" class="form-label">Nivel</label>
                            <select type="text" class="form-control" id="edit_nivel" name="nivel" required>
                                <option value="">Seleccionar nivel...</option>
                                <?php foreach($niveles as $nivel): ?>
                                <option value="<?= htmlspecialchars(($nivel['id_nivel'] ?? '')) ?>">
                                    <?= htmlspecialchars(($nivel['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_aula" class="form-label">Aula</label>
                            <select type="text" class="form-control" id="edit_aula" name="aula" required>
                                <option value="">Seleccionar aula...</option>
                                <?php foreach($aulas as $aula): ?>
                                <option value="<?= htmlspecialchars(($aula['id_aula'] ?? '')) ?>">
                                    <?= htmlspecialchars(($aula['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ciclo" class="form-label">Ciclo Escolar</label>
                            <select type="text" class="form-control" id="edit_ciclo" name="ciclo" required>
                                <option value="">Seleccionar ciclo...</option>
                                <?php foreach($ciclos as $ciclo): ?>
                                <option value="<?= htmlspecialchars(($ciclo['id_ciclo'] ?? '')) ?>">
                                    <?= htmlspecialchars(($ciclo['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_turno" class="form-label">Turno</label>
                            <select type="text" class="form-control" id="edit_turno" name="turno" required>
                                <option value="">Seleccionar turno...</option>
                                <?php foreach($turnos as $turno): ?>
                                <option value="<?= htmlspecialchars(($turno['id_turno'] ?? '')) ?>">
                                    <?= htmlspecialchars(($turno['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="maestro" class="form-label">Maestro</label>
                            <select type="text" class="form-control" id="edit_maestro" name="maestro" required>
                                <option value="">Seleccionar maestro...</option>
                                <?php foreach($maestros as $maestro): ?>
                                <option value="<?= htmlspecialchars(($maestro['id_usuario'] ?? '')) ?>">
                                    <?= htmlspecialchars(($maestro['nombre'] ?? '')) ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="edit_grupo">Guardar Cambios</button>
                            <a href="lista_alumnos.php?id_grupo=<?= $grupo['id_grupo'] ?? '' ?>" 
                            class="btn btn-info" 
                            title="Editar lista de alumnos de este grupo">
                            <i class="bi bi-people-fill"></i> Editar Lista Alumnos
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Eliminación -->
    <div class="modal fade" id="modal_eliminar" tabindex="-1" aria-labelledby="modal_eliminar_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="includes/grupos/grupos.php" method="POST">
                <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modal_eliminar_label">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este grupo? Esta acción no puede deshacerse.
                <input type="hidden" name="grupo_eliminar" id="id_grupo_eliminar">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="delete_grupo" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        function fill_editar_grupo(id_grupo, id_nivel, id_aula, id_ciclo, id_turno, id_usuario){
            document.getElementById("edit_id_grupo").value = id_grupo;
            document.getElementById("edit_nivel").value = id_nivel;
            document.getElementById("edit_aula").value = id_aula;
            document.getElementById("edit_ciclo").value = id_ciclo;
            document.getElementById("edit_turno").value = id_turno;
            document.getElementById("edit_maestro").value = id_usuario;
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const eliminarModal = document.getElementById('modal_eliminar');
        eliminarModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const idGrupo = button.getAttribute('data-id');
            document.getElementById('id_grupo_eliminar').value = idGrupo;
        });
    });
</script>
</body>

</html>