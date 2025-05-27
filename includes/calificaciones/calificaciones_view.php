<?php
function new_row_grupos(array $results) {
    foreach ($results as $result): ?>
        <tr>
            <td><?= htmlspecialchars($result['nombre']) ?></td>
            <td>
                <form method="POST" style="display:inline;" action="crud_calificaciones.php">
                    <input type="hidden" name="id_grupo" value="<?= htmlspecialchars($result['id_grupo']) ?>" />
                    <input type="hidden" name="id_materia" value="<?= htmlspecialchars($result['id_materia']) ?>" />
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach;
}

function new_row_califs($alumnos) {
    foreach ($alumnos as $alumno): ?>
        <tr>
            <td><?= htmlspecialchars($alumno['matricula']) ?></td>
            <td><?= htmlspecialchars($alumno['nombre']) ?></td>
            <td><?= is_null($alumno['parcial1']) && is_null($alumno['parcial2']) ? '-' : number_format(floatval($alumno['promedio']), 2) ?></td>
            <td><input type="number" name="parcial1[<?= $alumno['id_alumno'] ?>]" min="0" max="10" step="0.1" class="form-control" value="<?= htmlspecialchars($alumno['parcial1'] ?? '') ?>" /></td>
            <td><input type="number" name="parcial2[<?= $alumno['id_alumno'] ?>]" min="0" max="10" step="0.1" class="form-control" value="<?= htmlspecialchars($alumno['parcial2'] ?? '') ?>" /></td>
        </tr>
    <?php endforeach;
}
