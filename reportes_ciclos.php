<?php
require_once 'includes/config.php';
require_login();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .chart-container {
            width: 80%;
            margin: 20px auto;
        }
    </style>
</head>

<body class="container mt-4">
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 3): ?>
    <div class="mb-3">
        <a href="menu_admin.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Menú de Director
        </a>
    </div>
    <?php endif; ?> 

    <h2 class="mb-4">Desempeño por Ciclo Escolar</h2>

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

    <h3 class="mt-5 mb-3">Promedios por Materia</h3>
    <div class="chart-container">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('includes/reportes/reporte.php')
                .then(response => response.json())
                .then(data => {
                    createChart(data, 'bar');
                })
                .catch(error => console.error('Error:', error));

            function createChart(chartData, type) {
                const ctx = document.getElementById('myChart').getContext('2d');
                const materias = Object.keys(chartData);
                const promedios = Object.values(chartData);

                const colores = [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ];

                const bordes = [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ];

                new Chart(ctx, {
                    type: type,
                    data: {
                        labels: materias,
                        datasets: [{
                            label: 'Promedios por Materia',
                            data: promedios,
                            backgroundColor: colores.slice(0, materias.length),
                            borderColor: bordes.slice(0, materias.length),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y.toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Promedio'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Materias'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
