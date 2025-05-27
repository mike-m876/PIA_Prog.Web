<?php
function new_row(array $result)
{
    foreach ($result as $grupo): ?>
        <tr>
            <td><?= htmlspecialchars($grupo['nivel']) ?></td>
            <td><?= htmlspecialchars($grupo['aula']) ?></td>
            <td><?= htmlspecialchars($grupo['ciclo']) ?></td>
            <td><?= htmlspecialchars($grupo['turno']) ?></td>
            <td><?= htmlspecialchars($grupo['maestro']) ?></td>
            <td>
                <!-- EDITAR-->
                <button class="btn btn-sm btn-primary"
                    name="edit_user"
                    data-bs-toggle="modal"
                    data-bs-target="#modal_editar"
                   onclick="fill_editar_grupo(
                        '<?= $grupo['id_grupo'] ?>',
                        '<?= $grupo['id_nivel'] ?>',
                        '<?= $grupo['id_aula'] ?>',
                        '<?= $grupo['id_ciclo'] ?>',
                        '<?= $grupo['id_turno'] ?>',
                        '<?= $grupo['id_maestro'] ?>'
                    )">
                    <i class="bi bi-pencil-fill"></i>
                </button>
                <!-- ELIMINAR -->
                <button class="btn btn-danger btn-sm" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modal_eliminar" 
                    data-id="<?= $grupo['id_grupo'] ?>">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </td>
        </tr>
<?php endforeach;
}
