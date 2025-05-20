<?php
//REFERENCIAS A TABLAS
function get_materias(PDO $pdo){
    $query = "SELECT * FROM materias WHERE activo = 1;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_materia_by_nom(PDO $pdo, string $nombre){
    $query="SELECT nombre FROM materias WHERE nombre = :nombre;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_materia_by_id(PDO $pdo, int $id_materia){
    $query = ("SELECT * FROM materias WHERE id_materia = :id_materia;");
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_materia', $id_materia);
    $stmt ->execute();
    return $stmt -> fetch(PDO::FETCH_ASSOC);
}

//ACTUALIZAR TABLAS
function nueva_materia(PDO $pdo, string $nombre, string $desc_materia){
    $query = "SELECT * FROM materias WHERE nombre = :nombre;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($res) > 0) {
    $_SESSION['mensaje'] = "Ya existe otra materia con ese nombre.";
    $_SESSION['tipo'] = "danger";
} else {
    $insert = $pdo->prepare("INSERT INTO materias (nombre, desc_materia) VALUES (:nombre, :desc_materia)");
    $insert->bindParam(':nombre', $nombre);
    $insert->bindParam(':desc_materia', $desc_materia);
    $insert->execute();
    $_SESSION['mensaje'] = "Materia actualizada correctamente.";
    $_SESSION['tipo'] = "success";
}
}

function edit_materia(PDO $pdo, int $id_materia, string $nombre, string $desc_materia = ''){
    $edit = $pdo->prepare("UPDATE materias SET nombre = :nombre, desc_materia = :desc_materia WHERE id_materia = :id_materia");
    $edit->bindParam(':id_materia', $id_materia);
    $edit->bindParam(':nombre', $nombre);
    $edit->bindParam(':desc_materia', $desc_materia, PDO::PARAM_STR);
    $edit->execute();
}

function delete_materia(PDO $pdo, int $id_materia){
    $delete = $pdo->prepare("UPDATE materias SET activo = 0 WHERE id_materia = :id_materia;");
    $delete->bindParam(':id_materia', $id_materia);
    $delete->execute();
    return $delete;
}