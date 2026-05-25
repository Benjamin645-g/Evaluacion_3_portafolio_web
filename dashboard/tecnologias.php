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
            $stmt = $pdo->prepare("INSERT INTO tecnologias (nombre, porcentaje, color, orden) VALUES (?, ?, ?, (SELECT COALESCE(MAX(o.orden),0)+1 FROM tecnologias o))");
            $stmt->execute([
                sanitize($_POST['nombre']),
                (int)$_POST['porcentaje'],
                sanitize($_POST['color'])
            ]);
            $success = '✅ Tecnología agregada correctamente.';
        } catch (Exception $e) {
            $error = 'Error al agregar: ' . $e->getMessage();
        }
    } elseif ($accion === 'eliminar') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare("DELETE FROM tecnologias WHERE id=?")->execute([$id]);
        $success = '✅ Tecnología eliminada.';
    }
}

$tecnologias = getTecnologias($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnologías | Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
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
                <h4><i class="bi bi-bar-chart-steps me-2" style="color:var(--green)"></i>Gestionar Tecnologías</h4>
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
                <div class="dash-card-title"><i class="bi bi-bar-chart-steps"></i> Tecnologías actuales</div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Nombre</th><th>Porcentaje</th><th>Barra</th><th>Color</th><th>Acciones</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tecnologias as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['nombre']) ?></td>
                            <td><strong><?= (int)$t['porcentaje'] ?>%</strong></td>
                            <td style="min-width:120px;">
                                <div style="height:6px;border-radius:3px;background:#e5e7eb;">
                                    <div style="width:<?= (int)$t['porcentaje'] ?>%;height:100%;border-radius:3px;background:<?= htmlspecialchars($t['color']) ?>;"></div>
                                </div>
                            </td>
                            <td>
                                <span style="background:<?= htmlspecialchars($t['color']) ?>22;color:<?= htmlspecialchars($t['color']) ?>;border-radius:20px;padding:.2rem .65rem;font-size:.78rem;font-weight:600;">
                                    <?= htmlspecialchars($t['color']) ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta tecnología?')">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                    <button type="submit" class="btn-sm-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Agregar tecnología -->
                <div style="background:#f8fafc;border:1px dashed #e5e7eb;border-radius:10px;padding:1rem;margin-top:1rem;">
                    <p style="font-weight:700;font-size:.9rem;margin-bottom:.7rem;">
                        <i class="bi bi-plus-circle me-1" style="color:var(--green);"></i>Agregar tecnología
                    </p>
                    <form method="POST">
                        <input type="hidden" name="accion" value="agregar">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:.82rem;font-weight:600;">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-sm"
                                    placeholder="ej: TypeScript" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" style="font-size:.82rem;font-weight:600;">Porcentaje</label>
                                <input type="number" name="porcentaje" class="form-control form-control-sm"
                                    placeholder="%" min="0" max="100" value="70">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" style="font-size:.82rem;font-weight:600;">Color</label>
                                <input type="color" name="color" class="form-control form-control-sm form-control-color"
                                    value="#1a9650" title="Color de la barra">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn-primary-green w-100">Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>