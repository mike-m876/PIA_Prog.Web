<?php

function new_row(array $turnos){
    foreach($turnos as $turno): ?>
    <tr>
        <td><?= htmlspecialchars(strval($turno['id_turno'])) ?></td>
        <td><?= htmlspecialchars($turno['nombre']) ?></td>
        <td>
            <button 
                class="btn btn-warning"
                onclick="fill_editar_turno(<?= $turno['id_turno'] ?>, 
                    '<?= htmlspecialchars($turno['nombre'], ENT_QUOTES) ?>')"
                data-bs-toggle="modal" 
                data-bs-target="#modal_editar">
                Editar
            </button>
        </td>
    </tr>
    <?php endforeach;
}

function check_turnos_errors() {
    if(isset($_SESSION["errors_turnos"])){
        $errors = $_SESSION["errors_turnos"];
        unset($_SESSION["errors_turnos"]); ?>
        
        <?php foreach($errors as $error): ?>
            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endforeach; ?>
    <?php }
}