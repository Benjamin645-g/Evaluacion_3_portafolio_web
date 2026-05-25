<?php

$current = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-grid-fill me-2" style="color:var(--green)"></i>Panel Admin</h5>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php" class="nav-link <?= $current === 'index.php' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Inicio
        </a>
        <a href="biografia.php" class="nav-link <?= $current === 'biografia.php' ? 'active' : '' ?>">
            <i class="bi bi-person-circle"></i> Biografía
        </a>
        <a href="habilidades.php" class="nav-link <?= $current === 'habilidades.php' ? 'active' : '' ?>">
            <i class="bi bi-tools"></i> Habilidades
        </a>
        <a href="tecnologias.php" class="nav-link <?= $current === 'tecnologias.php' ? 'active' : '' ?>">
            <i class="bi bi-bar-chart-steps"></i> Tecnologías
        </a>
        <a href="proyectos.php" class="nav-link <?= $current === 'proyectos.php' ? 'active' : '' ?>">
            <i class="bi bi-folder2-open"></i> Proyectos
        </a>
        <a href="mensajes.php" class="nav-link <?= $current === 'mensajes.php' ? 'active' : '' ?>">
            <i class="bi bi-envelope"></i> Mensajes
            <?php
            global $pdo;
            if (isset($pdo)) {
                $noLeidos = getMensajesNoLeidos($pdo);
                if ($noLeidos > 0): ?>
                <span class="badge-unread ms-auto"><?= $noLeidos ?></span>
            <?php endif; } ?>
        </a>
        <a href="../index.php" target="_blank" class="nav-link">
            <i class="bi bi-eye"></i> Ver Portafolio
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="btn-logout">
            <i class="bi bi-box-arrow-left"></i> Cerrar sesión
        </a>
    </div>
</aside>