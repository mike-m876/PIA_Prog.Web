<?php

//REFERENCIAS A TABLAS
function get_grupo(PDO $pdo)
{
    $query = "SELECT g.id_grupo, n.nombre as nivel, a.nombre as aula, 
        c.nombre as ciclo, t.nombre as turno, 
        CONCAT(u.nombres, ' ', u.apellido_pat) as maestro,
        (SELECT COUNT(*) FROM alumnos_grupo ag WHERE ag.id_grupo = g.id_grupo) as num_alumnos
        FROM grupo g
        JOIN nivel n ON g.id_nivel = n.id_nivel
        JOIN aula a ON g.id_aula = a.id_aula
        JOIN ciclos_escolares c ON g.id_ciclo = c.id_ciclo
        JOIN turnos t ON g.id_turno = t.id_turno
        JOIN usuarios u ON g.id_maestro = u.id_usuario
        ORDER BY g.id_grupo DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function filtrar_grupo(PDO $pdo, int $id_nivel, int $id_turno, int $id_ciclo)
{
    $filtros = [
        'id_nivel' => $id_nivel,
        'id_turno' => $id_turno,
        'id_ciclo' => $id_ciclo,
    ];

    $where = [];
    $params = [];

    foreach ($filtros as $campo => $valor) {
        if ($valor !== null && $valor !== '') {
            $where[] = "g.$campo = :$campo";
            $params[":$campo"] = $valor;
        }
    }

    $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    $query = "SELECT g.id_grupo, n.nombre as nivel, a.nombre as aula, 
        c.nombre as ciclo, t.nombre as turno, 
        CONCAT(u.nombres, ' ', u.apellido_pat) as maestro,
        FROM grupo g
        JOIN nivel n ON g.id_nivel = n.id_nivel
        JOIN aula a ON g.id_aula = a.id_aula
        JOIN ciclos c ON g.id_ciclo = c.id_ciclo
        JOIN turnos t ON g.id_turno = t.id_turno
        JOIN usuarios u ON g.id_maestro = u.id_usuario
        $whereClause
        ORDER BY g.id_grupo DESC";


    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
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
}

function actualizar_grupo(PDO $pdo, int $id_nivel, int $id_aula, int $id_ciclo, int $id_turno, int $id_maestro)
{
    $query = "UPDATE grupo SET
            id_nivel = :id_nivel,
            id_aula = :id_aula, 
            id_ciclo = :id_ciclo, 
            id_turno = :id_turno, 
            id_maestro = :id_maestro) 
            WHERE id_grupo = :id_grupo;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_grupo', $id_grupo);
    $stmt->bindParam(':id_nivel', $id_nivel);
    $stmt->bindParam(':id_aula', $id_aula);
    $stmt->bindParam(':id_ciclo', $id_ciclo);
    $stmt->bindParam(':id_turno', $id_turno);
    $stmt->bindParam(':id_maestro', $id_maestro);
}
