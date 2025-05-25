<?php

function get_mater_grupo ($pdo){
    $query = 
    "SELECT 
        m.id_materia as id_materia,
        g.id_grupo as id_grupo,
        concat(n.nombre, ' - ', a.nombre, ' - ', m.nombre) as nombre
    FROM materia_grupo mg
    JOIN grupo g ON mg.id_grupo = g.id_grupo
    JOIN nivel n ON g.id_nivel = n.id_nivel
    JOIN aula a ON g.id_aula = a.id_aula
    JOIN ciclos_escolares c ON g.id_ciclo = c.id_ciclo
    JOIN turnos t ON g.id_turno = t.id_turno
    JOIN materias m ON mg.id_materia = m.id_materia
    ORDER BY g.id_grupo;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_calificaciones($pdo, $id_materia, $id_grupo) {
    $query =
           "SELECT 
                c.*,
                u.id_usuario as matricula,
                CONCAT(u.nombres, ' ', u.apellido_pat, ' ', u.apellido_mat) AS nombre,
                c.periodo1 as parcial1,
                c.periodo2 as parcial2,
                c.prom_final as promedio,
                c.fecha_actualizacion as fecha
            FROM calificaciones c
            JOIN usuarios u ON c.id_alumno = u.id_usuario
            WHERE c.id_materia = :id_materia AND c.id_grupo = :id_grupo;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
    $stmt->bindParam(':id_grupo', $id_grupo, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function update_calificaciones($pdo, $id_alumno, $parcial1 = null, $parcial2 = null) {
    $parcial1 = ($parcial1 !== null && $parcial1 !== '') ? floatval($parcial1) : null;
    $parcial2 = ($parcial2 !== null && $parcial2 !== '') ? floatval($parcial2) : null;

    if ($parcial1 === null && $parcial2 === null) {
        return;
    }

    $query = "SELECT periodo1, periodo2 FROM calificaciones WHERE id_alumno = :id_alumno";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nuevo_p1 = ($parcial1 !== null) ? $parcial1 : (is_numeric($row['periodo1']) ? floatval($row['periodo1']) : null);
        $nuevo_p2 = ($parcial2 !== null) ? $parcial2 : (is_numeric($row['periodo2']) ? floatval($row['periodo2']) : null);

        if (
            ($parcial1 === null || $nuevo_p1 == $row['periodo1']) &&
            ($parcial2 === null || $nuevo_p2 == $row['periodo2'])
        ) {
            return;
        }
    } else {
        $nuevo_p1 = ($parcial1 !== null) ? $parcial1 : 0;
        $nuevo_p2 = ($parcial2 !== null) ? $parcial2 : 0;
    }

    if ($nuevo_p1 !== null && $nuevo_p2 !== null) {
        $promedio = ($nuevo_p1 + $nuevo_p2) / 2;
    } elseif ($nuevo_p1 !== null) {
        $promedio = $nuevo_p1;
    } elseif ($nuevo_p2 !== null) {
        $promedio = $nuevo_p2;
    } else {
        $promedio = null; 
    }

    if ($row) {
        $stmt_update = $pdo->prepare("
            UPDATE calificaciones 
            SET periodo1 = :p1, periodo2 = :p2, prom_final = :prom 
            WHERE id_alumno = :id_alumno
        ");
    } else {
        $stmt_update = $pdo->prepare("
            INSERT INTO calificaciones (id_alumno, periodo1, periodo2, prom_final)
            VALUES (:id_alumno, :p1, :p2, :prom)
        ");
    }

    $stmt_update->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
    $stmt_update->bindParam(':p1', $nuevo_p1);
    $stmt_update->bindParam(':p2', $nuevo_p2);
    $stmt_update->bindParam(':prom', $promedio);

    $stmt_update->execute();
}
