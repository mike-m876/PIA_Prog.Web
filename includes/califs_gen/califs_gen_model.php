<?php

function get_mater_grupo ($pdo){
    $query = "SELECT 
    n.nombre AS nivel,
    a.nombre AS aula,
    c.nombre AS ciclo,
    t.nombre AS turno,
    m.nombre AS materia,
    m.id_materia,          
    g.id_grupo
FROM grupo g
JOIN nivel n ON g.id_nivel = n.id_nivel
JOIN aula a ON g.id_aula = a.id_aula
JOIN ciclos_escolares c ON g.id_ciclo = c.id_ciclo
JOIN turnos t ON g.id_turno = t.id_turno
JOIN materia_grupo mg ON g.id_grupo = mg.id_grupo
JOIN materias m ON mg.id_materia = m.id_materia
WHERE g.activo = 1
ORDER BY g.id_grupo;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_calificaciones_by_mat_and_grupo($pdo, $id_materia, $id_grupo) {
    $query = "
    SELECT 
        c.*,  
        n.nombre AS nivel,
        a.nombre AS aula,
        ce.nombre AS ciclo,
        t.nombre AS turno,
        m.nombre AS materia,
        CONCAT(u.nombres, ' ', u.apellido_pat, ' ', u.apellido_mat) AS maestro
    FROM calificaciones c
    JOIN grupo g ON c.id_grupo = g.id_grupo
    JOIN nivel n ON g.id_nivel = n.id_nivel
    JOIN aula a ON g.id_aula = a.id_aula
    JOIN ciclos_escolares ce ON g.id_ciclo = ce.id_ciclo
    JOIN turnos t ON g.id_turno = t.id_turno
    JOIN materias m ON c.id_materia = m.id_materia
    JOIN usuarios u ON g.id_maestro = u.id_usuario
    WHERE c.id_materia = :id_materia AND c.id_grupo = :id_grupo;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
    $stmt->bindParam(':id_grupo', $id_grupo, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updt_califs(PDO $pdo, int $id_grupo, int $id_materia, int $id_alumno, float $p1, float $p2, float $prom_final): bool 
{
    $query = "UPDATE calificaciones 
              SET parcial1 = :parcial1, 
                  parcial2 = :parcial2, 
                  prom_final = :prom_final
              WHERE id_grupo = :id_grupo AND id_materia = :id_materia AND id_alumno = :id_alumno";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':parcial1', $p1, PDO::PARAM_STR);
        $stmt->bindParam(':parcial2', $p2, PDO::PARAM_STR);
        $stmt->bindParam(':prom_final', $prom_final, PDO::PARAM_STR);
        $stmt->bindParam(':id_grupo', $id_grupo, PDO::PARAM_INT);
        $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
        $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            $insertQuery = "INSERT INTO calificaciones 
                            (id_grupo, id_materia, id_alumno, parcial1, parcial2, prom_final)
                            VALUES (:id_grupo, :id_materia, :id_alumno, :parcial1, :parcial2, :prom_final)";
            
            $stmt = $pdo->prepare($insertQuery);
            $stmt->bindParam(':parcial1', $p1, PDO::PARAM_STR);
            $stmt->bindParam(':parcial2', $p2, PDO::PARAM_STR);
            $stmt->bindParam(':prom_final', $prom_final, PDO::PARAM_STR);
            $stmt->bindParam(':id_grupo', $id_grupo, PDO::PARAM_INT);
            $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
            $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
            return $stmt->execute();
        }
        
        return true;
    } catch (PDOException $e) {
        error_log("Error al actualizar calificaciones: " . $e->getMessage());
        return false;
    }
}
