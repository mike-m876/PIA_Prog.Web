<?php
function imprimir_tabla_grupos(array $result)
{
    foreach ($result as $grupo): ?>
        <tr>
            <td><?= htmlspecialchars($grupo['nivel']) ?></td>
            <td><?= htmlspecialchars($grupo['aula']) ?></td>
            <td><?= htmlspecialchars($grupo['ciclo']) ?></td>
            <td><?= htmlspecialchars($grupo['turno']) ?></td>
            <td><?= htmlspecialchars($grupo['materia']) ?></td>
            <td>
                <a href="#" 
                   class="btn btn-sm btn-primary"
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
                </a>
            </td>
        </tr>
    <?php endforeach;
}

function imprimir_tabla_califs_edit($calificaciones) {
    if (empty($calificaciones)) {
        echo '<tr><td colspan="5" class="text-center">No hay alumnos para mostrar.</td></tr>';
        return;
    }
    foreach ($calificaciones as $row) {
        echo '<tr>';
            echo '<td>';
            echo '<a href="?id_grupo=' . $row['id_grupo'] . '&id_materia=' . urlencode($row['id_materia']) . '#modalEditCalifs" class="btn btn-sm btn-info">';
            echo 'Ver Calificaciones</a>';
            echo '</td>';
        echo '</tr>';
    }
}