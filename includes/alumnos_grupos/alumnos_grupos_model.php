<?php

function get_grupo(PDO $pdo) {
    $query = "SELECT 
                g.id_grupo,
                CONCAT(n.nombre, ' - ', a.nombre, ' - ', t.nombre) AS nombre_grupo
              FROM grupo g
              WHERE g.activo = 1
              JOIN nivel n ON g.id_nivel = n.id_nivel
              JOIN aula a ON g.id_aula = a.id_aula
              JOIN turnos t ON g.id_turno = t.id_turno";
    return $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

function get_grupo_by_id(PDO $pdo, int $id_grupo) {
    $stmt = $pdo->prepare("SELECT * FROM grupo WHERE id_grupo = ?");
    $stmt->execute([$id_grupo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_alumnos(PDO $pdo) {
    $query = "SELECT 
                id_usuario, 
                CONCAT(nombres, ' ', apellido_pat, ' ', apellido_mat) AS nombre_completo 
              FROM usuarios 
              WHERE id_rol = 1 AND activo = 1";
    return $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

function get_alumnos_grupo(PDO $pdo, int $id_grupo) {
    $query = "SELECT 
                u.id_usuario, 
                CONCAT(u.nombres, ' ', u.apellido_pat, ' ', u.apellido_mat) AS nombre_completo
              FROM alumnos_grupo ag
              JOIN usuarios u ON ag.id_alumno = u.id_usuario
              WHERE ag.id_grupo = :id_grupo";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_grupo', $id_grupo, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function add_alumnos(PDO $pdo, int $id_grupo, int $id_alumno)
{
    $queryInsertAlumno = "INSERT IGNORE INTO alumnos_grupo (id_grupo, id_alumno) VALUES (:id_grupo, :id_alumno)";
    $stmtInsertAlumno = $pdo->prepare($queryInsertAlumno);
    $stmtInsertAlumno->execute([
        ':id_grupo' => $id_grupo,
        ':id_alumno' => $id_alumno
    ]);

    $queryMaterias = "SELECT id_materia FROM materia_grupo WHERE id_grupo = :id_grupo";
    $stmtMaterias = $pdo->prepare($queryMaterias);
    $stmtMaterias->execute([':id_grupo' => $id_grupo]);
    $materias = $stmtMaterias->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($materias)) {
        $queryInsertCalif = "INSERT IGNORE INTO calificaciones (id_alumno, id_grupo, id_materia) VALUES (:id_alumno, :id_grupo, :id_materia)";
        $stmtInsertCalif = $pdo->prepare($queryInsertCalif);

        foreach ($materias as $id_materia) {
            $stmtInsertCalif->execute([
                ':id_alumno' => $id_alumno,
                ':id_grupo' => $id_grupo,
                ':id_materia' => $id_materia
            ]);
        }
    }
}function quitar_alumno(PDO $pdo, int $id_alumno, int $id_grupo) {
    $query = "DELETE FROM alumnos_grupo WHERE id_grupo = :id_grupo AND id_alumno = :id_alumno";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_grupo', $id_grupo);
    $stmt->bindParam(':id_alumno', $id_alumno);
    $stmt->execute();
}

function edit_grupo(PDO $pdo, int $id_grupo, int $id_nivel, int $id_aula, int $id_ciclo, int $id_turno, int $id_maestro) {
    $query = "UPDATE grupo 
              SET id_nivel = :nivel, id_aula = :aula, id_ciclo = :ciclo, id_turno = :turno, id_maestro = :maestro 
              WHERE id_grupo = :grupo";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nivel', $id_nivel);
    $stmt->bindParam(':aula', $id_aula);
    $stmt->bindParam(':ciclo', $id_ciclo);
    $stmt->bindParam(':turno', $id_turno);
    $stmt->bindParam(':maestro', $id_maestro);
    $stmt->bindParam(':grupo', $id_grupo);
    $stmt->execute();
}

function get_all_niveles(PDO $pdo) {
    return $pdo->query("SELECT * FROM nivel")->fetchAll(PDO::FETCH_ASSOC);
}

function get_all_aulas(PDO $pdo) {
    return $pdo->query("SELECT * FROM aula")->fetchAll(PDO::FETCH_ASSOC);
}

function get_all_turnos(PDO $pdo) {
    return $pdo->query("SELECT * FROM turnos")->fetchAll(PDO::FETCH_ASSOC);
}

function get_all_ciclos(PDO $pdo) {
    return $pdo->query("SELECT * FROM ciclos_escolares")->fetchAll(PDO::FETCH_ASSOC);
}

function get_maestros(PDO $pdo) {
    $query = "SELECT id_usuario, CONCAT(nombres, ' ', apellido_pat, ' ', apellido_mat) AS nombre_completo 
              FROM usuarios 
              WHERE id_rol = 2 AND activo = 1";
    return $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

function get_calificaciones_by_alumno(PDO $pdo, int $id_alumno) {
    $query = "SELECT 
                m.nombre AS materia,
                c.periodo1,
                c.periodo2,
                ROUND((c.periodo1 + c.periodo2) / 2, 1) AS promedio
              FROM calificaciones c
              JOIN materias m ON c.id_materia = m.id_materia
              WHERE c.id_alumno = :id_alumno";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id_alumno' => $id_alumno]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}