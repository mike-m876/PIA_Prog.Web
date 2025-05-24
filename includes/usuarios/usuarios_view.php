<?php

function new_row(array $usuarios){
    foreach($usuarios as $usuario): ?>
    <tr>
        <td><?= htmlspecialchars(strval($usuario['id_usuario'])) ?></td>
        <td><?= htmlspecialchars($usuario['curp']) ?></td>
        <td><?= htmlspecialchars($usuario['nombres']) 
        . " " . htmlspecialchars($usuario['apellido_pat'])
        . " " . htmlspecialchars($usuario['apellido_mat'])?></td>        
        <td><?= htmlspecialchars($usuario['telefono']) ?></td>
        <td><?= htmlspecialchars($usuario['email']) ?></td>
        <td><?= htmlspecialchars($usuario['rol'])?></td>
        <td><?= htmlspecialchars($usuario['estado']) ?></td>
        <td><?= htmlspecialchars($usuario['fecha_registro']) ?></td>
        <td>
            <button class="btn btn-sm btn-primary"
                    name="edit_user" 
                    data-bs-toggle="modal"  
                    data-bs-target="#modal_editar"
                    onclick="fill_editar_usuario( 
                        '<?= htmlspecialchars(strval($usuario['id_usuario'] ?? '')) ?>')">  
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