<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard/biografia.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Por favor completa todos los campos.';
    } else {
        // Verificar contra la BD con password_verify (hash bcrypt)
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user']      = $user['username'];
            $_SESSION['admin_id']        = $user['id'];
            header('Location: dashboard/biografia.php');
            exit;
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión | Portafolio Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="login-logo"><i class="bi bi-person-badge-fill"></i></div>
            <h2 class="login-title">Panel Administrativo</h2>
            <p class="login-subtitle">Ingresa tus credenciales para acceder</p>
        </div>

        <?php if ($error): ?>
        <div class="alert-login" style="background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;">
            <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label fw-semibold" for="username">
                    <i class="bi bi-person me-1" style="color:#1a9650"></i>Usuario
                </label>
                <input type="text" id="username" name="username" class="form-control"
                       placeholder="Tu usuario"
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" for="password">
                    <i class="bi bi-lock me-1" style="color:#1a9650"></i>Contraseña
                </label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control"
                           placeholder="Tu contraseña" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePass">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-login-submit">
                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="index.php" style="color:#1a9650;font-size:0.9rem;text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i>Volver al portafolio
            </a>
        </div>

        <div class="mt-3 p-2 rounded" style="background:#f8f9fa;font-size:0.8rem;color:#6c757d;text-align:center;">
            <strong>Credenciales:</strong> usuario: <code>admin</code> | contraseña: <code>password</code>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePass').addEventListener('click', function() {
            const pass = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (pass.type === 'password') {
                pass.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                pass.type = 'password';
                icon.className = 'bi bi-eye';
            }
        });
    </script>
</body>
</html>