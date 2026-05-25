<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/* Verifica si el usuario está autenticado */
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}


/* Redirige al login si no está autenticado */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
}


/* Sanitiza entrada del usuario*/
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}


/*  Retorna datos de biografía */
function getBiografia($pdo) {
    $stmt = $pdo->query("SELECT * FROM biografia LIMIT 1");
    return $stmt->fetch();
}


 /*Retorna Habilidades activas ordenadas */

function getHabilidades($pdo) {
    $stmt = $pdo->query("SELECT * FROM habilidades WHERE activo = 1 ORDER BY orden ASC");
    return $stmt->fetchAll();
}


 /* retorna tecnologías activas ordenadas */

function getTecnologias($pdo) {
    $stmt = $pdo->query("SELECT * FROM tecnologias WHERE activo = 1 ORDER BY orden ASC");
    return $stmt->fetchAll();
}


 /* Retorna proyectos activos ordenados */
 
function getProyectos($pdo) {
    $stmt = $pdo->query("SELECT * FROM proyectos WHERE activo = 1 ORDER BY orden ASC");
    return $stmt->fetchAll();
}

/**
 * Cuenta mensajes no leídos
 */
function getMensajesNoLeidos($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM contacto WHERE leido = 0");
    $result = $stmt->fetch();
    return $result['total'];
}
?>