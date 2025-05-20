<?php
header('Content-Type: application/json');
require_once '../dbh.php';
include 'grupos_model.php';

$result = get_grupo($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtrar_grupo'])) {
    $id_grupo = (int) $_POST['grupo'];
    $id_nivel = (int) $_POST['nivel'];
    $id_aula = (int) $_POST['aula'];
    $id_ciclo = (int) $_POST['ciclo'];
    $id_turno = (int) $_POST['turno'];
    $id_maestro = (int) $_POST['maestro'];

    $errors = [];

    //filtrar_grupo();
}
try {

    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'listar_grupos':
            $filtros = [
                'id_nivel' => $_GET['id_nivel'] ?? null,
                'id_turno' => $_GET['id_turno'] ?? null,
                'id_ciclo' => $_GET['id_ciclo'] ?? null
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

            $sql = "SELECT g.id_grupo, n.nombre as nivel, a.nombre as aula, 
                    c.nombre as ciclo, t.nombre as turno, 
                    CONCAT(u.nombres, ' ', u.apellido_pat) as maestro,
                    (SELECT COUNT(*) FROM alumnos_grupo ag WHERE ag.id_grupo = g.id_grupo) as num_alumnos
                    FROM grupo g
                    JOIN nivel n ON g.id_nivel = n.id_nivel
                    JOIN aula a ON g.id_aula = a.id_aula
                    JOIN ciclos_escolares c ON g.id_ciclo = c.id_ciclo
                    JOIN turnos t ON g.id_turno = t.id_turno
                    JOIN usuarios u ON g.id_maestro = u.id_usuario
                    $whereClause
                    ORDER BY g.id_grupo DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'data' => $grupos]);
            break;

        case 'obtener_grupo':
            $id_grupo = $_GET['id_grupo'];

            $sql = "SELECT * FROM grupo WHERE id_grupo = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_grupo]);
            $grupo = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'data' => $grupo]);
            break;

        case 'crear_grupo':
            $data = json_decode(file_get_contents('php://input'), true);

            $sql = "INSERT INTO grupo (id_nivel, id_aula, id_ciclo, id_turno, id_maestro) 
                    VALUES (:id_nivel, :id_aula, :id_ciclo, :id_turno, :id_maestro)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);

            echo json_encode(['success' => true, 'id_grupo' => $pdo->lastInsertId()]);
            break;

        case 'actualizar_grupo':
            $data = json_decode(file_get_contents('php://input'), true);
            $id_grupo = $data['id_grupo'];
            unset($data['id_grupo']);

            $sql = "UPDATE grupo SET 
                    id_nivel = :id_nivel, 
                    id_aula = :id_aula, 
                    id_ciclo = :id_ciclo, 
                    id_turno = :id_turno, 
                    id_maestro = :id_maestro
                    WHERE id_grupo = $id_grupo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);

            echo json_encode(['success' => true]);
            break;

        case 'eliminar_grupo':
            $id_grupo = $_GET['id_grupo'];

            // Eliminar relaciones primero
            $pdo->beginTransaction();

            $sql1 = "DELETE FROM alumnos_grupo WHERE id_grupo = ?";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute([$id_grupo]);

            $sql2 = "DELETE FROM materia_grupo WHERE id_grupo = ?";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([$id_grupo]);

            $sql3 = "DELETE FROM grupo WHERE id_grupo = ?";
            $stmt3 = $pdo->prepare($sql3);
            $stmt3->execute([$id_grupo]);

            $pdo->commit();

            echo json_encode(['success' => true]);
            break;

        case 'listar_alumnos_grupo':
            $id_grupo = $_GET['id_grupo'];

            $sql = "SELECT u.id_usuario, u.matricula, 
                    CONCAT(u.nombres, ' ', u.apellido_pat, ' ', u.apellido_mat) as nombre_completo
                    FROM alumnos_grupo ag
                    JOIN usuarios u ON ag.id_alumno = u.id_usuario
                    WHERE ag.id_grupo = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_grupo]);
            $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'data' => $alumnos]);
            break;

        case 'listar_alumnos_disponibles':
            $id_grupo = $_GET['id_grupo'];
            $busqueda = $_GET['busqueda'] ?? '';

            $sql = "SELECT u.id_usuario, u.matricula, 
                    CONCAT(u.nombres, ' ', u.apellido_pat, ' ', u.apellido_mat) as nombre_completo
                    FROM usuarios u
                    WHERE u.id_rol = 3 AND u.matricula IS NOT NULL 
                    AND u.id_usuario NOT IN (
                        SELECT id_alumno FROM alumnos_grupo WHERE id_grupo = ?
                    )";

            $params = [$id_grupo];

            if (!empty($busqueda)) {
                $sql .= " AND (u.matricula LIKE ? OR u.nombres LIKE ? OR u.apellido_pat LIKE ? OR u.apellido_mat LIKE ?)";
                $paramBusqueda = "%$busqueda%";
                array_push($params, $paramBusqueda, $paramBusqueda, $paramBusqueda, $paramBusqueda);
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'data' => $alumnos]);
            break;

        case 'agregar_alumno':
            $id_grupo = $_GET['id_grupo'];
            $id_alumno = $_GET['id_alumno'];

            $sql = "INSERT INTO alumnos_grupo (id_grupo, id_alumno) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_grupo, $id_alumno]);

            echo json_encode(['success' => true]);
            break;

        case 'quitar_alumno':
            $id_grupo = $_GET['id_grupo'];
            $id_alumno = $_GET['id_alumno'];

            $sql = "DELETE FROM alumnos_grupo WHERE id_grupo = ? AND id_alumno = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_grupo, $id_alumno]);

            echo json_encode(['success' => true]);
            break;

        case 'obtener_opciones':
            $tabla = $_GET['tabla'];

            $sql = "SELECT * FROM $tabla";

            if ($tabla == 'usuarios') {
                $sql = "SELECT id_usuario as id, CONCAT(nombres, ' ', apellido_pat) as nombre 
                        FROM usuarios WHERE id_rol = 2"; // Maestros
            }

            $stmt = $pdo->query($sql);
            $opciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'data' => $opciones]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}
