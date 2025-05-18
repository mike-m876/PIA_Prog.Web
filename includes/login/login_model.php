<?php

declare (strict_types= 1);

function get_user(object $pdo, int $matricula, int $id_rol) {
    $query = "SELECT * FROM usuarios WHERE id_usuario = :matricula AND id_rol = :id_rol";
    $stmt  = $pdo->prepare($query);
    $stmt-> bindParam(":matricula", $matricula);
    $stmt ->bindParam(":id_rol", $id_rol);
    $stmt -> execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
} 

function get_roles(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id_rol, nombre FROM roles;");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
