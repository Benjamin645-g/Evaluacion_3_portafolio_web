<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();

// Estadísticas desde la BD
$totalProyectos  = $pdo->query("SELECT COUNT(*) FROM proyectos WHERE activo=1")->fetchColumn();
$totalHabilidades= $pdo->query("SELECT COUNT(*) FROM habilidades WHERE activo=1")->fetchColumn();
$totalTecnologias= $pdo->query("SELECT COUNT(*) FROM tecnologias WHERE activo=1")->fetchColumn();
$totalMensajes   = $pdo->query("SELECT COUNT(*) FROM contacto")->fetchColumn();
$noLeidos        = getMensajesNoLeidos($pdo);
$bio             = getBiografia($pdo);

// Últimos mensajes
$ultimosMensajes = $pdo->query("SELECT * FROM contacto ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
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
                <h4><i class="bi bi-speedometer2 me-2" style="color:var(--green)"></i>Bienvenido, <?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?></h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="avatar-top"><?= strtoupper(substr($_SESSION['admin_user'] ?? 'A', 0, 1)) ?></div>
                <span style="font-weight:600;font-size:.9rem;"><?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?></span>
            </div>
        </div>

        <div class="dashboard-content">

            <!-- Tarjetas de estadísticas -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="dash-stat-card">
                        <div class="dash-stat-icon"><i class="bi bi-folder2-open"></i></div>
                        <div class="dash-stat-info">
                            <h3><?= $totalProyectos ?></h3>
                            <p>Proyectos</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="dash-stat-card">
                        <div class="dash-stat-icon"><i class="bi bi-tools"></i></div>
                        <div class="dash-stat-info">
                            <h3><?= $totalHabilidades ?></h3>
                            <p>Habilidades</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="dash-stat-card">
                        <div class="dash-stat-icon"><i class="bi bi-bar-chart-steps"></i></div>
                        <div class="dash-stat-info">
                            <h3><?= $totalTecnologias ?></h3>
                            <p>Tecnologías</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="dash-stat-card" style="border-left-color:<?= $noLeidos > 0 ? '#dc3545' : 'var(--green)' ?>;">
                        <div class="dash-stat-icon" style="background:<?= $noLeidos > 0 ? '#fce8e8' : '' ?>;color:<?= $noLeidos > 0 ? '#dc3545' : '' ?>;">
                            <i class="bi bi-envelope<?= $noLeidos > 0 ? '-exclamation' : '' ?>"></i>
                        </div>
                        <div class="dash-stat-info">
                            <h3><?= $totalMensajes ?></h3>
                            <p>Mensajes <?= $noLeidos > 0 ? "($noLeidos sin leer)" : '' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <!-- Accesos rápidos -->
                <div class="col-12 col-md-4">
                    <div class="dash-card h-100">
                        <div class="dash-card-title"><i class="bi bi-lightning-charge"></i> Accesos rápidos</div>
                        <div class="d-flex flex-column gap-2">
                            <a href="biografia.php" class="btn-primary-green text-center" style="text-decoration:none;padding:.6rem;">
                                <i class="bi bi-person-circle me-2"></i>Editar Biografía
                            </a>
                            <a href="proyectos.php" class="btn-primary-green text-center" style="text-decoration:none;padding:.6rem;">
                                <i class="bi bi-folder2-open me-2"></i>Gestionar Proyectos
                            </a>
                            <a href="habilidades.php" class="btn-primary-green text-center" style="text-decoration:none;padding:.6rem;">
                                <i class="bi bi-tools me-2"></i>Gestionar Habilidades
                            </a>
                            <a href="mensajes.php" class="btn-primary-green text-center" style="text-decoration:none;padding:.6rem;">
                                <i class="bi bi-envelope me-2"></i>Ver Mensajes
                                <?php if ($noLeidos > 0): ?>
                                <span class="badge-unread ms-1"><?= $noLeidos ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="../index.php" target="_blank" class="btn-sm-navy text-center" style="text-decoration:none;padding:.6rem;border-radius:8px;">
                                <i class="bi bi-eye me-2"></i>Ver Portafolio
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Últimos mensajes -->
                <div class="col-12 col-md-8">
                    <div class="dash-card h-100">
                        <div class="dash-card-title"><i class="bi bi-inbox"></i> Últimos mensajes</div>
                        <?php if (empty($ultimosMensajes)): ?>
                        <div class="text-center py-4" style="color:var(--gray);">
                            <i class="bi bi-inbox" style="font-size:2.5rem;opacity:0.3;"></i>
                            <p class="mt-2">No hay mensajes todavía.</p>
                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr><th>Estado</th><th>Nombre</th><th>Asunto</th><th>Fecha</th></tr>
                                </thead>
                                <tbody>
                                <?php foreach ($ultimosMensajes as $m): ?>
                                <tr style="<?= !$m['leido'] ? 'background:#f0faf4;font-weight:600;' : '' ?>">
                                    <td>
                                        <?php if (!$m['leido']): ?>
                                        <span style="background:#d4edda;color:#155724;padding:.2rem .5rem;border-radius:20px;font-size:.75rem;font-weight:700;">Nuevo</span>
                                        <?php else: ?>
                                        <span style="background:#e9ecef;color:#6c757d;padding:.2rem .5rem;border-radius:20px;font-size:.75rem;">Leído</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-size:.88rem;"><?= htmlspecialchars($m['nombre']) ?></td>
                                    <td style="font-size:.85rem;"><?= htmlspecialchars(substr($m['asunto'], 0, 35)) ?></td>
                                    <td style="font-size:.82rem;white-space:nowrap;"><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="mensajes.php" class="btn-sm-green mt-2" style="display:inline-block;text-decoration:none;">
                            Ver todos los mensajes <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>