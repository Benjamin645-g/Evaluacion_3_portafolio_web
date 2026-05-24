<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'bpacheco');
define('DB_PASS', 'BpX94kLm?');
define('DB_NAME', 'bpacheco_db2');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die(json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]));
}

// Función conectar() por compatibilidad con otros archivos
function conectar() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die(json_encode(['error' => 'Error: ' . $conn->connect_error]));
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}
?>