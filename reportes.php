<?php
require_once 'includes/dbh.php';

try {
    $stmt = $pdo->query("
        SELECT 
            ce.nombre AS ciclo,
            ROUND(AVG(c.prom_final), 2) AS promedio_general
        FROM calificaciones c
        JOIN grupo g ON g.id_grupo = c.id_grupo
        JOIN ciclos_escolares ce ON ce.id_ciclo = g.id_ciclo
        GROUP BY ce.id_ciclo
    ");
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte por Ciclo Escolar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-4">
    <h2 class="mb-4">Desempeño por Ciclo Escolar</h2>

    <div class="mb-4 text-center">
        <img src="includes/reportes/reoprtes_gen.php" alt="Promedios Ciclo" class="img-fluid" style="max-width:600px;">
    </div>

    <?php if (count($resultados) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Ciclo Escolar</th>
                    <th>Promedio General</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['ciclo']) ?></td>
                        <td><?= htmlspecialchars($fila['promedio_general']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No hay datos disponibles para mostrar.</div>
    <?php endif; ?>
</body>

</html>