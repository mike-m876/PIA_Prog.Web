<?php

//REFERENCIAS A TABLAS
function get_grupo(PDO $pdo)
{
    $query = "SELECT 
        g.id_grupo, 
        g.id_nivel, n.nombre AS nivel, 
        g.id_aula, a.nombre AS aula, 
        g.id_ciclo, c.nombre AS ciclo, 
        g.id_turno, t.nombre AS turno, 
        g.id_maestro, CONCAT(u.nombres, ' ', u.apellido_pat) AS maestro
    FROM grupo g
    JOIN nivel n ON g.id_nivel = n.id_nivel
    JOIN aula a ON g.id_aula = a.id_aula
    JOIN ciclos_escolares c ON g.id_ciclo = c.id_ciclo
    JOIN turnos t ON g.id_turno = t.id_turno
    JOIN usuarios u ON g.id_maestro = u.id_usuario
    ORDER BY g.id_grupo DESC;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_nivel(PDO $pdo)
{
    $query = "SELECT * FROM nivel;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_aula(PDO $pdo)
{
    $query = "SELECT * FROM aula;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_ciclo(PDO $pdo)
{
    $query = "SELECT * FROM ciclos_escolares;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_turno(PDO $pdo)
{
    $query = "SELECT * FROM turnos;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_maestro(PDO $pdo)
{
    $query = "SELECT id_usuario, CONCAT(nombres, ' ', apellido_pat, ' ', apellido_mat) AS nombre
            FROM usuarios
            WHERE id_rol = 2 AND activo = 1;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_materias(PDO $pdo)
{
    $query = "SELECT id_materia FROM materias WHERE activo = 1"; 
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//ACTUALIZACIÓN DE TABLAS
function crear_grupo(PDO $pdo, int $id_nivel, int $id_aula, int $id_ciclo, int $id_turno, int $id_maestro)
{
    $query = "INSERT INTO grupo (id_nivel, id_aula, id_ciclo, id_turno, id_maestro) 
              VALUES (:id_nivel, :id_aula, :id_ciclo, :id_turno, :id_maestro)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_nivel', $id_nivel);
    $stmt->bindParam(':id_aula', $id_aula);
    $stmt->bindParam(':id_ciclo', $id_ciclo);
    $stmt->bindParam(':id_turno', $id_turno);
    $stmt->bindParam(':id_maestro', $id_maestro);
    $stmt->execute();

    $id_grupo = (int) $pdo->lastInsertId();

    $materias = get_materias($pdo);

    $queryInsertMateria = "INSERT INTO materia_grupo (id_grupo, id_materia) VALUES (:id_grupo, :id_materia)";
    $stmtInsertMateria = $pdo->prepare($queryInsertMateria);

    foreach ($materias as $materia) {
        $stmtInsertMateria->execute([
            ':id_grupo' => $id_grupo,
            ':id_materia' => $materia['id_materia']
        ]);
}

    $queryAlumnos = "SELECT id_alumno FROM alumnos_grupo WHERE id_grupo = :id_grupo";
    $stmtAlumnos = $pdo->prepare($queryAlumnos);
    $stmtAlumnos->execute([':id_grupo' => $id_grupo]);
    $alumnos = $stmtAlumnos->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($alumnos)) {
        $queryInsertCalif = "INSERT IGNORE INTO calificaciones (id_alumno, id_grupo, id_materia) VALUES (:id_alumno, :id_grupo, :id_materia)";
        $stmtInsertCalif = $pdo->prepare($queryInsertCalif);

        foreach ($alumnos as $id_alumno) {
            foreach ($materias as $materia) {
                $stmtInsertCalif->execute([
                    ':id_alumno' => $id_alumno,
                    ':id_grupo' => $id_grupo,
                    ':id_materia' => $materia['id_materia']
                ]);
            }
        }
    }

    return $id_grupo;
}


function edit_grupo(PDO $pdo, int $id_grupo, int $id_nivel, int $id_aula, int $id_ciclo, int $id_turno, int $id_maestro)
{
    $query = "UPDATE grupo SET
            id_nivel = :id_nivel,
            id_aula = :id_aula, 
            id_ciclo = :id_ciclo, 
            id_turno = :id_turno, 
            id_maestro = :id_maestro 
            WHERE id_grupo = :id_grupo;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_grupo', $id_grupo);
    $stmt->bindParam(':id_nivel', $id_nivel);
    $stmt->bindParam(':id_aula', $id_aula);
    $stmt->bindParam(':id_ciclo', $id_ciclo);
    $stmt->bindParam(':id_turno', $id_turno);
    $stmt->bindParam(':id_maestro', $id_maestro);
    $stmt->execute();
}

