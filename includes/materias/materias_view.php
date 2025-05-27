<?php

function new_row(array $materias){
    foreach($materias as $materia): ?>
    <tr>
        <td><?= htmlspecialchars($materia['nombre']) ?></td>
        <td><?= htmlspecialchars($materia['desc_materia']) ?></td>
        <td>
            <button 
                class="btn btn-warning"
                onclick="fill_editar_materia(<?= $materia['id_materia'] ?>, 
                    '<?= htmlspecialchars($materia['nombre'], ENT_QUOTES) ?>', 
                    `<?= htmlspecialchars($materia['desc_materia'], ENT_QUOTES) ?>`)"
                data-bs-toggle="modal" 
                data-bs-target="#modal_editar">
                Editar
            </button>
        </td>
    </tr>
    <?php endforeach;
}

function check_materias_errors() {
    if(isset($_SESSION["errors_materias"])){
        $errors = $_SESSION["errors_materias"];
        unset($_SESSION["errors_materias"]); ?>
        
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