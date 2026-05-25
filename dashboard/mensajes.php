<?php
// dashboard/mensajes.php - Ver mensajes de contacto
require_once '../includes/db.php';
require_once '../includes/functions.php';
requireLogin();
 
$msg = ''; $msgType = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);
 
    if ($action === 'marcar_leido') {
        $pdo->prepare("UPDATE contacto SET leido=1 WHERE id=?")->execute([$id]);
        $msg = 'Mensaje marcado como leído.'; $msgType = 'success';
    } elseif ($action === 'delete') {
        $pdo->prepare("DELETE FROM contacto WHERE id=?")->execute([$id]);
        $msg = 'Mensaje eliminado.'; $msgType = 'success';
    } elseif ($action === 'marcar_todos') {
        $pdo->query("UPDATE contacto SET leido=1");
        $msg = 'Todos los mensajes marcados como leídos.'; $msgType = 'success';
    }
}
 
$stmt = $pdo->query("SELECT * FROM contacto ORDER BY created_at DESC");
$mensajes = $stmt->fetchAll();
$noLeidos = getMensajesNoLeidos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto | Admin</title>
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
                <h4><i class="bi bi-envelope me-2" style="color:var(--green)"></i>Mensajes de Contacto
                    <?php if ($noLeidos > 0): ?>
                    <span class="badge-unread ms-2"><?= $noLeidos ?></span>
                    <?php endif; ?>
                </h4>
            </div>
            <?php if ($noLeidos > 0): ?>
            <form method="POST" style="margin:0;">
                <input type="hidden" name="action" value="marcar_todos">
                <button type="submit" class="btn-sm-green">
                    <i class="bi bi-check2-all me-1"></i>Marcar todos como leídos
                </button>
            </form>
            <?php endif; ?>
        </div>
 
        <div class="dashboard-content">
            <?php if ($msg): ?>
            <div class="<?= $msgType === 'success' ? 'alert-success-custom' : 'alert-error-custom' ?> auto-hide-alert">
                <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($msg) ?>
            </div>
            <?php endif; ?>
 
            <!-- Estadísticas -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="dash-stat-card">
                        <div class="dash-stat-icon"><i class="bi bi-envelope"></i></div>
                        <div class="dash-stat-info">
                            <h3><?= count($mensajes) ?></h3>
                            <p>Total mensajes</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="dash-stat-card" style="border-left-color:#dc3545;">
                        <div class="dash-stat-icon" style="background:#fce8e8;color:#dc3545;"><i class="bi bi-envelope-exclamation"></i></div>
                        <div class="dash-stat-info">
                            <h3><?= $noLeidos ?></h3>
                            <p>Sin leer</p>
                        </div>
                    </div>
                </div>
            </div>
 
            <div class="dash-card">
                <div class="dash-card-title"><i class="bi bi-inbox"></i> Bandeja de entrada</div>
                <?php if (empty($mensajes)): ?>
                <div class="text-center py-5" style="color:var(--gray);">
                    <i class="bi bi-inbox" style="font-size:3rem;opacity:0.3;"></i>
                    <p class="mt-2">No hay mensajes todavía.</p>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Estado</th><th>Nombre</th><th>Correo</th><th>Asunto</th><th>Fecha</th><th>Acciones</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mensajes as $m): ?>
                            <tr style="<?= !$m['leido'] ? 'background:#f0faf4;font-weight:600;' : '' ?>">
                                <td>
                                    <?php if (!$m['leido']): ?>
                                    <span style="background:#d4edda;color:#155724;padding:0.2rem 0.5rem;border-radius:20px;font-size:0.75rem;font-weight:700;">Nuevo</span>
                                    <?php else: ?>
                                    <span style="background:#e9ecef;color:#6c757d;padding:0.2rem 0.5rem;border-radius:20px;font-size:0.75rem;">Leído</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($m['nombre']) ?></td>
                                <td style="font-size:0.88rem;"><?= htmlspecialchars($m['email']) ?></td>
                                <td style="font-size:0.88rem;"><?= htmlspecialchars(substr($m['asunto'], 0, 40)) ?></td>
                                <td style="font-size:0.82rem;white-space:nowrap;">
                                    <?= date('d/m/Y H:i', strtotime($m['created_at'])) ?>
                                </td>
                                <td>
                                    <!-- CORRECCIÓN: uso de data-* en lugar de onclick con addslashes -->
                                    <button class="btn-sm-green me-1 btn-ver-msg"
                                        data-nombre="<?= htmlspecialchars($m['nombre'], ENT_QUOTES) ?>"
                                        data-email="<?= htmlspecialchars($m['email'], ENT_QUOTES) ?>"
                                        data-asunto="<?= htmlspecialchars($m['asunto'], ENT_QUOTES) ?>"
                                        data-mensaje="<?= htmlspecialchars($m['mensaje'], ENT_QUOTES) ?>"
                                        data-fecha="<?= date('d/m/Y H:i', strtotime($m['created_at'])) ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if (!$m['leido']): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="marcar_leido">
                                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                        <button type="submit" class="btn-sm-navy me-1"><i class="bi bi-check2"></i></button>
                                    </form>
                                    <?php endif; ?>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este mensaje?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                        <button type="submit" class="btn-sm-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
 
<!-- Modal Ver Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-envelope-open me-2"></i>Mensaje Recibido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:var(--gray);font-size:0.82rem;">DE</label>
                    <p id="modal_nombre" style="font-weight:700;margin:0;"></p>
                    <p id="modal_email" style="font-size:0.88rem;color:var(--green);margin:0;"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:var(--gray);font-size:0.82rem;">ASUNTO</label>
                    <p id="modal_asunto" style="font-weight:600;margin:0;"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:var(--gray);font-size:0.82rem;">MENSAJE</label>
                    <div id="modal_mensaje" style="background:var(--light);padding:1rem;border-radius:8px;font-size:0.95rem;line-height:1.6;white-space:pre-wrap;"></div>
                </div>
                <div>
                    <label class="form-label fw-semibold" style="color:var(--gray);font-size:0.82rem;">FECHA</label>
                    <p id="modal_fecha" style="font-size:0.85rem;margin:0;"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a id="modal_reply" href="#" class="btn-primary-green" style="text-decoration:none;padding:0.5rem 1.2rem;border-radius:8px;">
                    <i class="bi bi-reply me-1"></i>Responder
                </a>
            </div>
        </div>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
<script>

document.querySelectorAll('.btn-ver-msg').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var d = this.dataset;
        document.getElementById('modal_nombre').textContent  = d.nombre;
        document.getElementById('modal_email').textContent   = d.email;
        document.getElementById('modal_asunto').textContent  = d.asunto;
        document.getElementById('modal_mensaje').textContent = d.mensaje;
        document.getElementById('modal_fecha').textContent   = d.fecha;
        document.getElementById('modal_reply').href =
            'mailto:' + d.email + '?subject=Re: ' + encodeURIComponent(d.asunto);
        new bootstrap.Modal(document.getElementById('modalMensaje')).show();
    });
});
</script>
</body>
</html>