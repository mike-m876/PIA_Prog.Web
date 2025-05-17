<?php

declare (strict_types= 1);

function get_user(object $pdo, string $matricula) {
    $query = "SELECT * FROM usuarios WHERE id_usuario = :matricula";
    $stmt  = $pdo->prepare($query);
    $stmt-> bindParam(":matricula", $matricula);
    $stmt -> execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
} 