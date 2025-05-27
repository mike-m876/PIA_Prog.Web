<?php
require_once '../dbh.php';
header('Content-Type: application/json');

function get_promedios_por_materia($pdo){
    $query = "
        SELECT m.nombre AS materia, AVG(c.prom_final) AS promedio_materia
        FROM calificaciones c
        JOIN materias m ON m.id_materia = c.id_materia
        GROUP BY c.id_materia
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$promedios = get_promedios_por_materia($pdo);

$promedios_por_materia = [];

foreach ($promedios as $promedio) {
    $nombre_materia = $promedio['materia'];
    $promedio_materia = floatval($promedio['promedio_materia']);
    $promedios_por_materia[$nombre_materia] = $promedio_materia;
}

echo json_encode($promedios_por_materia);
