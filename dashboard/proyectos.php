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
            $stmt = $pdo->prepare("INSERT INTO proyectos (titulo, descripcion, tecnologias_usadas, url_demo, url_github, orden) VALUES (?, ?, ?, ?, ?, (SELECT COALESCE(MAX(o.orden),0)+1 FROM proyectos o))");
            $stmt->execute([
                sanitize($_POST['titulo']),
                sanitize($_POST['descripcion']),
                sanitize($_POST['tecnologias_usadas']),
                sanitize($_POST['url_demo']),
                sanitize($_POST['url_github'])
            ]);
            $success = '✅ Proyecto agregado correctamente.';
        } catch (Exception $e) {
            $error = 'Error al agregar: ' . $e->getMessage();
        }
    } elseif ($accion === 'eliminar') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare("DELETE FROM proyectos WHERE id=?")->execute([$id]);
        $success = '✅ Proyecto eliminado.';
    }
}

$proyectos = getProyectos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos | Dashboard</title>
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
                <h4><i class="bi bi-folder2-open me-2" style="color:var(--green)"></i>Gestionar Proyectos</h4>
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
                <div class="dash-card-title"><i class="bi bi-folder2-open"></i> Proyectos actuales</div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Título</th><th>Tecnologías</th><th>Demo</th><th>GitHub</th><th>Acciones</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($proyectos as $p): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($p['titulo']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars(substr($p['descripcion'], 0, 50)) ?>...</small>
                            </td>
                            <td style="font-size:.85rem;"><?= htmlspecialchars($p['tecnologias_usadas']) ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($p['url_demo']) ?>" target="_blank" style="color:var(--green);">
                                    <i class="bi bi-box-arrow-up-right"></i> Ver
                                </a>
                            </td>
                            <td>
                                <a href="<?= htmlspecialchars($p['url_github']) ?>" target="_blank" style="color:var(--navy);">
                                    <i class="bi bi-github"></i> GitHub
                                </a>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este proyecto?')">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn-sm-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Agregar proyecto -->
                <div style="background:#f8fafc;border:1px dashed #e5e7eb;border-radius:10px;padding:1rem;margin-top:1rem;">
                    <p style="font-weight:700;font-size:.9rem;margin-bottom:.7rem;">
                        <i class="bi bi-plus-circle me-1" style="color:var(--green);"></i>Agregar proyecto
                    </p>
                    <form method="POST">
                        <input type="hidden" name="accion" value="agregar">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="titulo" class="form-control form-control-sm"
                                    placeholder="Título del proyecto" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="tecnologias_usadas" class="form-control form-control-sm"
                                    placeholder="Tecnologías (PHP, JS, MySQL...)">
                            </div>
                            <div class="col-12">
                                <textarea name="descripcion" class="form-control form-control-sm" rows="2"
                                    placeholder="Descripción del proyecto"></textarea>
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="url_demo" class="form-control form-control-sm"
                                    placeholder="URL Demo">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="url_github" class="form-control form-control-sm"
                                    placeholder="URL GitHub">
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