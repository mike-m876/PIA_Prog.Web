<?php
require_once 'includes/config.php';
require_login();

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$actual = $input['actual'] ?? '';
$nueva = $input['nueva'] ?? '';
$id_usuario = $_SESSION['id_usuario'] ?? null;

if (!$id_usuario || !$actual || !$nueva) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$stmt = $conn->prepare("SELECT psswd_hash FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->bind_result($hash_actual);
$stmt->fetch();
$stmt->close();

if (!password_verify($actual, $hash_actual)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Contraseña actual incorrecta']);
    exit;
}

$nueva_hash = password_hash($nueva, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE usuarios SET psswd_hash = ? WHERE id_usuario = ?");
$stmt->bind_param("si", $nueva_hash, $id_usuario);
$success = $stmt->execute();
$stmt->close();

if ($success) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
}
