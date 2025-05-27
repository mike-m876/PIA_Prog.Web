<?php
function get_usuarios(PDO $pdo, string $curp = '') {
  $results_per_page = 25;

  $condicionCurp = $curp !== '' ? " AND u.curp LIKE :curp" : '';

  $countQuery = "SELECT COUNT(u.id_usuario) AS total FROM usuarios u WHERE u.id_rol != 3 $condicionCurp";
  $stmt = $pdo->prepare($countQuery);
  if ($curp !== '') {
    $stmt->bindValue(':curp', '%' . $curp . '%');
  }
  $stmt->execute();
  $total_results = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
  
  $total_pages = ceil($total_results / $results_per_page);
  $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
  $page = max(1, min($page, $total_pages));
  $start_from = ($page - 1) * $results_per_page;

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
              e.nombre AS estado,
              u.fecha_registro
            FROM usuarios u
            JOIN roles r ON u.id_rol = r.id_rol
            JOIN estado e ON u.id_estado = e.id_estado
            WHERE u.id_rol != 3 $condicionCurp
            LIMIT :start_from, :results_per_page";

  $stmt = $pdo->prepare($query);
  if ($curp !== '') {
    $stmt->bindValue(':curp', '%' . $curp . '%');
  }
  $stmt->bindValue(':start_from', $start_from, PDO::PARAM_INT);
  $stmt->bindValue(':results_per_page', $results_per_page, PDO::PARAM_INT);
  $stmt->execute();
  $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return [
    'usuarios' => $usuarios,
    'page' => $page,
    'total_pages' => $total_pages
  ];
}

function get_estados(PDO $pdo) {
  $query = "SELECT * FROM estado";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_user_by_id($pdo, $matricula) {
  $query = "SELECT id_usuario, email, nombres 
            FROM usuarios 
            WHERE id_usuario = :matricula";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam('matricula', $matricula, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function edit_usuario(PDO $pdo, $matricula, $id_estado, $activo) {
  $query = "UPDATE usuarios 
            SET id_estado = :id_estado,
                activo = :activo
            WHERE id_usuario = :matricula";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id_estado', $id_estado);
  $stmt->bindParam(':activo', $activo);
  $stmt->bindParam(':matricula', $matricula);
  $stmt->execute();
}