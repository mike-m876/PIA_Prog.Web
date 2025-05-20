<?php

function new_row(array $result)
{
    foreach ($result as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['nivel']) ?></td>
            <td><?= htmlspecialchars($row['aula']) ?></td>
            <td><?= htmlspecialchars($row['ciclo']) ?></td>
            <td><?= htmlspecialchars($row['turno']) ?></td>
            <td><?= htmlspecialchars($row['maestro']) ?></td>
            <td><?= htmlspecialchars(strval($row['num_alumnos'])) ?></td>
            <td>
                <button class="btn btn-sm btn-primary"
                    name="edit_user"
                    data-bs-toggle="modal"
                    data-bs-target="#modal_editar">
                    <i class="bi bi-pencil-fill"></i>
                </button>
            </td>
        </tr>
<?php endforeach;
}
