<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();

$success = '';
$error   = '';

// Guardar cambios en la BD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE biografia SET
            nombre=?, titulo=?, descripcion=?, email=?, ubicacion=?, disponibilidad=?, foto=?
            WHERE id=1");
        $stmt->execute([
            sanitize($_POST['nombre']),
            sanitize($_POST['titulo']),
            sanitize($_POST['descripcion']),
            sanitize($_POST['email']),
            sanitize($_POST['ubicacion']),
            sanitize($_POST['disponibilidad']),
            sanitize($_POST['foto'])
        ]);
        $success = '✅ Biografía actualizada correctamente.';
    } catch (Exception $e) {
        $error = 'Error al guardar: ' . $e->getMessage();
    }
}

// Cargar datos actuales desde la BD
$bio = getBiografia($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biografía | Dashboard</title>
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
                <h4><i class="bi bi-person-circle me-2" style="color:var(--green)"></i>Editar Biografía</h4>
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
                <div class="dash-card-title"><i class="bi bi-person-circle"></i> Información Personal</div>
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre completo</label>
                            <input type="text" name="nombre" class="form-control"
                                value="<?= htmlspecialchars($bio['nombre'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Título profesional</label>
                            <input type="text" name="titulo" class="form-control"
                                value="<?= htmlspecialchars($bio['titulo'] ?? '') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($bio['descripcion'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correo electrónico</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($bio['email'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ubicación</label>
                            <input type="text" name="ubicacion" class="form-control"
                                value="<?= htmlspecialchars($bio['ubicacion'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Disponibilidad</label>
                            <input type="text" name="disponibilidad" class="form-control"
                                value="<?= htmlspecialchars($bio['disponibilidad'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Foto (ruta o URL)</label>
                            <input type="text" name="foto" class="form-control"
                                value="<?= htmlspecialchars($bio['foto'] ?? '') ?>">
                        </div>
                        <?php if (!empty($bio['foto'])): ?>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Vista previa</label><br>
                            <img src="../<?= htmlspecialchars($bio['foto']) ?>" alt="Foto"
                                style="width:80px;height:80px;object-fit:cover;border-radius:50%;border:3px solid var(--green);">
                        </div>
                        <?php endif; ?>
                        <div class="col-12">
                            <button type="submit" class="btn-primary-green">
                                <i class="bi bi-check2 me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>