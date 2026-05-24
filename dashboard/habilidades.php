<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();
 
$success = '';
$error   = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
 
    if ($accion === 'agregar') {
        try {
            $stmt = $pdo->prepare("INSERT INTO habilidades (nombre, icono, color, orden) VALUES (?, ?, ?, (SELECT COALESCE(MAX(o.orden),0)+1 FROM habilidades o))");
            $stmt->execute([
                sanitize($_POST['nombre']),
                sanitize($_POST['icono']),
                sanitize($_POST['color'])
            ]);
            $success = '✅ Habilidad agregada correctamente.';
        } catch (Exception $e) {
            $error = 'Error al agregar: ' . $e->getMessage();
        }
    } elseif ($accion === 'eliminar') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare("DELETE FROM habilidades WHERE id=?")->execute([$id]);
        $success = '✅ Habilidad eliminada.';
    }
}
 
$habilidades = getHabilidades($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habilidades | Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-wrapper">
    <?php include '_sidebar.php'; ?>
    <div class="dashboard-main">
        <div class="dashboard-topbar">
            <div class="d-flex align-items-center gap-3">
                <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--navy);color:white;border:none;border-radius:8px;padding:0.4rem 0.7rem;">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h4><i class="bi bi-tools me-2" style="color:var(--green)"></i>Gestionar Habilidades</h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="avatar-top"><?= strtoupper(substr($_SESSION['admin_user'] ?? 'A', 0, 1)) ?></div>
                <span style="font-weight:600;font-size:.9rem;"><?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?></span>
            </div>
        </div>
 
        <div class="dashboard-content">
            <?php if ($success): ?>
            <div class="alert-success-custom auto-hide-alert">
                <i class="bi bi-check-circle me-2"></i><?= $success ?>
            </div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="alert-error-custom">
                <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
 
            <div class="dash-card">
                <div class="dash-card-title"><i class="bi bi-tools"></i> Habilidades actuales</div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Nombre</th><th>Ícono</th><th>Color</th><th>Acciones</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($habilidades as $h): ?>
                        <tr>
                            <td><?= htmlspecialchars($h['nombre']) ?></td>
                            <td><i class="bi <?= htmlspecialchars($h['icono']) ?> me-1"></i><?= htmlspecialchars($h['icono']) ?></td>
                            <td>
                                <span style="background:<?= htmlspecialchars($h['color']) ?>22;color:<?= htmlspecialchars($h['color']) ?>;border-radius:20px;padding:.2rem .65rem;font-size:.78rem;font-weight:600;">
                                    <?= htmlspecialchars($h['color']) ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta habilidad?')">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id" value="<?= $h['id'] ?>">
                                    <button type="submit" class="btn-sm-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
 
                <!-- Agregar habilidad -->
                <div style="background:#f8fafc;border:1px dashed #e5e7eb;border-radius:10px;padding:1rem;margin-top:1rem;">
                    <p style="font-weight:700;font-size:.9rem;margin-bottom:.7rem;">
                        <i class="bi bi-plus-circle me-1" style="color:var(--green);"></i>Agregar habilidad
                    </p>
                    <form method="POST">
                        <input type="hidden" name="accion" value="agregar">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="nombre" class="form-control form-control-sm"
                                    placeholder="Nombre (ej: Vue.js)" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="icono" class="form-control form-control-sm"
                                    placeholder="Ícono Bootstrap (bi-star)">
                            </div>
                            <div class="col-md-2">
                                <input type="color" name="color" class="form-control form-control-sm form-control-color"
                                    value="#1a2332" title="Color del ícono">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn-primary-green w-100">Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>