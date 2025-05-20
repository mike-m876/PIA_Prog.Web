<?php

function encabezado($alumnos)
{
    if ($alumnos) {
        return '
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Grupo: Nivel ' . htmlspecialchars($alumnos['nivel']) . ' - Aula ' . htmlspecialchars($alumnos['aula']) . '</h2>
            </div>
            <div class="card-body">
                <h4 class="card-title">Maestro: ' . htmlspecialchars($alumnos['maestro']) . '</h4>
                <p class="card-text">Ciclo Escolar: ' . htmlspecialchars($alumnos['ciclo']) . ' | Turno: ' . htmlspecialchars($alumnos['turno']) . '</p>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_agregar_alumno">
                    Añadir Alumno
                </button>
            </div>
        </div>';
    } else {
        return '
        <div class="alert alert-danger">
            <p>Grupo no encontrado o ID no especificado.</p>
        </div>';
    }
}

function new_row($lista_alumnos)
{
    foreach ($lista_alumnos as $alumno): ?>
        <tr>
            <td><?= htmlspecialchars($alumno['id_usuario']) ?></td>
            <td><?= htmlspecialchars($alumno['nombre_completo']) ?></td>
            <td><?= htmlspecialchars($alumno['id_usuario']) ?></td>
            <td>
                <button class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modal_editar_alumno"
                    data-id="<?= htmlspecialchars($alumno['id_usuario']) ?>"
                    data-nombre="<?= htmlspecialchars($alumno['nombre_completo']) ?>">
                    <i class="bi bi-pencil-fill"></i>
                </button>
            </td>
        </tr>
<?php endforeach;
}
