<?php
header('Content-Type: application/json');
require 'includes/dbh.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === 'GET' && $action === 'leer') {
    $id_alumno = intval($_GET['id_alumno']);

    $sql = "SELECT 
                c.id_alumno,
                c.id_grupo,
                c.id_materia,
                c.periodo1,
                c.periodo2,
                c.prom_final,
                m.nombre AS nombre_materia,
                CONCAT(u.nombres, ' ', u.apellido_pat, ' ', u.apellido_mat) AS nombre_completo
            FROM calificaciones c
            JOIN materias m ON c.id_materia = m.id_materia
            JOIN usuarios u ON c.id_alumno = u.id_usuario
            WHERE c.id_alumno = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_alumno]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
    exit;
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input['action'] === 'actualizar-multiples') {
        $conn->beginTransaction();

        try {
            foreach ($input['data'] as $item) {
                $checkSql = "SELECT COUNT(*) FROM calificaciones 
                             WHERE id_alumno = ? AND id_grupo = ? AND id_materia = ?";
                $checkStmt = $conn->prepare($checkSql);
                $checkStmt->execute([
                    $item['id_alumno'],
                    $item['id_grupo'],
                    $item['id_materia']
                ]);

                $existe = $checkStmt->fetchColumn() > 0;

                if ($existe) {
                    $updateSql = "UPDATE calificaciones 
                                  SET periodo1 = ?, periodo2 = ?, prom_final = ?, fecha_actualizacion = NOW()
                                  WHERE id_alumno = ? AND id_grupo = ? AND id_materia = ?";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->execute([
                        $item['periodo1'],
                        $item['periodo2'],
                        $item['prom_final'],
                        $item['id_alumno'],
                        $item['id_grupo'],
                        $item['id_materia']
                    ]);
                } else {
                    $insertSql = "INSERT INTO calificaciones 
                                  (id_alumno, id_grupo, id_materia, periodo1, periodo2, prom_final, fecha_actualizacion)
                                  VALUES (?, ?, ?, ?, ?, ?, NOW())";
                    $insertStmt = $conn->prepare($insertSql);
                    $insertStmt->execute([
                        $item['id_alumno'],
                        $item['id_grupo'],
                        $item['id_materia'],
                        $item['periodo1'],
                        $item['periodo2'],
                        $item['prom_final']
                    ]);
                }
            }

            $conn->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $conn->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Petición no válida']);
