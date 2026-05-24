<?php
// contacto.php - Manejo del formulario de contacto
require_once 'includes/db.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

// Solo procesar si es petición AJAX POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    $nombre  = sanitize($_POST['nombre']  ?? '');
    $email   = sanitize($_POST['email']   ?? '');
    $asunto  = sanitize($_POST['asunto']  ?? '');
    $mensaje = sanitize($_POST['mensaje'] ?? '');

    // Validaciones
    $errors = [];
    if (empty($nombre))               $errors[] = 'El nombre es requerido.';
    if (empty($email))                $errors[] = 'El correo es requerido.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'El correo no es válido.';
    if (empty($asunto))               $errors[] = 'El asunto es requerido.';
    if (empty($mensaje))              $errors[] = 'El mensaje es requerido.';
    if (strlen($mensaje) < 10)        $errors[] = 'El mensaje debe tener al menos 10 caracteres.';

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    // Insertar en BD
    try {
        $stmt = $pdo->prepare("INSERT INTO contacto (nombre, email, asunto, mensaje) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $asunto, $mensaje]);
        echo json_encode(['success' => true, 'message' => '¡Mensaje enviado correctamente! Me pondré en contacto contigo pronto.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el mensaje. Intenta nuevamente.']);
    }
    exit;
}

// Si no es AJAX, redirigir al index
header('Location: index.php#contacto');
exit;
?>