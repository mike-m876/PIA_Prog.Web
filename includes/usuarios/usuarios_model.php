<?php

//REFERENCIAS A TABLAS
function get_usuario(PDO $pdo){
    $query = "SELECT 
                u.id_usuario,
                u.curp,
                u.nombres,
                u.apellido_pat,
                u.apellido_mat,
                u.telefono,
                u.email,
                r.nombre AS rol,
                u.activo,
                e.nombre as estado,
                u.fecha_registro
              FROM 
                usuarios u
              JOIN
                roles r ON u.id_rol = r.id_rol
              JOIN
                estado e on u.id_estado = e.id_estado;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_estados(PDO $pdo){
  $query = "SELECT * FROM estado";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}

function get_user_by_id($pdo, $matricula){
  $query = "SELECT id_usuario, email, nombres 
   FROM usuarios where id_usuario = :matricula;";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam('matricula', $matricula);
  $stmt->execute();
  return  $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//INSERCIÓN DE DATOS
function edit_usuario(PDO $pdo, $matricula, $id_estado, $activo){
  $query = "UPDATE usuarios 
            SET id_estado = :id_estado,
                activo = :activo
            WHERE id_usuario = :matricula ";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id_estado', $id_estado);
  $stmt->bindParam(':activo', $activo);
  $stmt->bindParam(':matricula', $matricula);

  $stmt->execute();
}