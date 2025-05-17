<?php

declare (strict_types= 1);

function get_user(object $pdo, int $matricula, int $id_rol) {
    $query = "SELECT * FROM usuarios WHERE id_usuario = :matricula AND id_rol = :id_rol";
    $stmt  = $pdo->prepare($query);
    $stmt-> bindParam(":matricula", $matricula);
    $stmt -> execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
} 