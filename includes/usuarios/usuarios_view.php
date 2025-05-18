<?php

function new_row(array $result){
    foreach($result as $row): ?>
    <tr>
        <td><?= htmlspecialchars(strval($row['id_usuario'])) ?></td>
        <td><?= htmlspecialchars($row['curp']) ?></td>
        <td><?= htmlspecialchars($row['nombres']) 
        . " " . htmlspecialchars($row['apellido_pat'])
        . " " . htmlspecialchars($row['apellido_mat'])?></td>        
        <td><?= htmlspecialchars($row['telefono']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['rol'])?></td>
        <td><?= htmlspecialchars($row['estado']) ?></td>
        <td><?= htmlspecialchars($row['fecha_registro']) ?></td>
        <td>
            <button class="btn btn-sm btn-primary"
                    name="edit_user" 
                    data-bs-toggle="modal"  
                    data-bs-target="#modal_editar"
                    onclick="fill_modal_editar( 
                        '<?= htmlspecialchars(strval($row['id_usuario'] ?? '')) ?>')">  
                <i class="bi bi-pencil-fill"></i>
            </button>
        </td>
    </tr>
    <?php endforeach;
}

function check_usuarios_errors() {
    if(isset($_SESSION["errors_usuarios"])){
        $errors = $_SESSION["errors_usuarios"];
        unset($_SESSION["errors_usuarios"]); ?>
        
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