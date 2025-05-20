<?php

function get_turnos(PDO $pdo){
    $query = "SELECT * FROM turnos WHERE activo = 1;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_turno_by_nom(PDO $pdo, string $nombre){
    $query="SELECT nombre FROM turnos WHERE nombre = :nombre;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_turno_by_id(PDO $pdo, int $id_turno){
    $query = ("SELECT * FROM turnos WHERE id_turno = :id_turno;");
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_turno', $id_turno);
    $stmt ->execute();
    return $stmt -> fetch(PDO::FETCH_ASSOC);
}

//ACTUALIZAR TABLAS
function nuevo_turno(PDO $pdo, string $nombre){
    $query = "SELECT * FROM turnos WHERE nombre = :nombre;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($res) > 0) {
    $_SESSION['mensaje'] = "Ya existe otra turno con ese nombre.";
    $_SESSION['tipo'] = "danger";
} else {
    $insert = $pdo->prepare("INSERT INTO turnos (nombre) VALUES (:nombre)");
    $insert->bindParam(':nombre', $nombre);
    $insert->execute();
    $_SESSION['mensaje'] = "Turno actualizada correctamente.";
    $_SESSION['tipo'] = "success";
}
}

function edit_turno(PDO $pdo, int $id_turno, string $nombre){
    $edit = $pdo->prepare("UPDATE turnos SET nombre = :nombre WHERE id_turno = :id_turno");
    $edit->bindParam(':id_turno', $id_turno);
    $edit->bindParam(':nombre', $nombre);
    $edit->execute();
}

function delete_turno(PDO $pdo, int $id_turno){
    $delete = $pdo->prepare("UPDATE turnos SET activo = 0 WHERE id_turno = :id_turno;");
    $delete->bindParam(':id_turno', $id_turno);
    $delete->execute();
    return $delete;
}