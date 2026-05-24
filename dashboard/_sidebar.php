<?php
// dashboard/_sidebar.php
$current = basename($_SERVER['PHP_SELF']);
?>
<aside class="dashboard-sidebar" id="dashSidebar">
    <div class="sidebar-brand">
        <i class="bi bi-grid-fill"></i>
        <span>Panel Admin</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-label">General</div>
        <a href="index.php" class="<?= $current === 'index.php' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Inicio
        </a>

        <div class="nav-section-label">Contenido</div>
        <a href="biografia.php" class="<?= $current === 'biografia.php' ? 'active' : '' ?>">
            <i class="bi bi-person-circle"></i> Biografía
        </a>
        <a href="habilidades.php" class="<?= $current === 'habilidades.php' ? 'active' : '' ?>">
            <i class="bi bi-tools"></i> Habilidades
        </a>
        <a href="tecnologias.php" class="<?= $current === 'tecnologias.php' ? 'active' : '' ?>">
            <i class="bi bi-bar-chart-steps"></i> Tecnologías
        </a>
        <a href="proyectos.php" class="<?= $current === 'proyectos.php' ? 'active' : '' ?>">
            <i class="bi bi-folder2-open"></i> Proyectos
        </a>
        <a href="mensajes.php" class="<?= $current === 'mensajes.php' ? 'active' : '' ?>">
            <i class="bi bi-envelope"></i> Mensajes
            <?php
            // Mostrar badge si hay mensajes sin leer
            global $pdo;
            if (isset($pdo)) {
                $noLeidos = getMensajesNoLeidos($pdo);
                if ($noLeidos > 0): ?>
                <span class="badge-unread ms-auto"><?= $noLeidos ?></span>
            <?php endif; } ?>
        </a>

        <div class="nav-section-label">Sitio</div>
        <a href="../index.php" target="_blank">
            <i class="bi bi-eye"></i> Ver Portafolio
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="btn-logout">
            <i class="bi bi-box-arrow-left"></i> Cerrar sesión
        </a>
    </div>
</aside>