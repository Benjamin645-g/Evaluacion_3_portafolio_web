<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Datos desde la base de datos
$biografia   = getBiografia($pdo);
$habilidades = getHabilidades($pdo);
$tecnologias = getTecnologias($pdo);
$proyectos   = getProyectos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($biografia['nombre']) ?> | Portafolio Web</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ==================== NAVBAR ==================== -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Mi Portafolio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="#biografia">Biografía</a></li>
                <li class="nav-item"><a class="nav-link" href="#habilidades">Habilidades</a></li>
                <li class="nav-item"><a class="nav-link" href="#tecnologias">Tecnologías</a></li>
                <li class="nav-item"><a class="nav-link" href="#proyectos">Proyectos</a></li>
                <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
            </ul>
            <a href="login.php" class="nav-link btn-login">
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                    <i class="bi bi-speedometer2"></i> Dashboard
                <?php else: ?>
                    <i class="bi bi-lock"></i> Inicio de Sesión
                <?php endif; ?>
            </a>
        </div>
    </div>
</nav>

<!-- ==================== BIOGRAFÍA ==================== -->
<section id="biografia">
    <div class="container">
        <div class="bio-card">
            <div class="bio-foto-wrapper">
                <?php if (!empty($biografia['foto']) && file_exists($biografia['foto'])): ?>
                    <img src="<?= htmlspecialchars($biografia['foto']) ?>" alt="Foto de perfil" class="bio-foto">
                <?php else: ?>
                    <div class="bio-foto-placeholder"><i class="bi bi-person-fill"></i></div>
                <?php endif; ?>
            </div>
            <div class="bio-info">
                <h1 class="bio-nombre"><?= htmlspecialchars($biografia['nombre']) ?></h1>
                <p class="bio-titulo"><?= htmlspecialchars($biografia['titulo']) ?></p>
                <p class="bio-descripcion"><?= htmlspecialchars($biografia['descripcion']) ?></p>
                <div class="bio-meta">
                    <span class="bio-meta-item">
                        <i class="bi bi-envelope-fill"></i><?= htmlspecialchars($biografia['email']) ?>
                    </span>
                    <span class="bio-meta-item">
                        <i class="bi bi-geo-alt-fill"></i><?= htmlspecialchars($biografia['ubicacion']) ?>
                    </span>
                    <span class="bio-meta-item">
                        <i class="bi bi-calendar-check-fill"></i><?= htmlspecialchars($biografia['disponibilidad']) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== HABILIDADES ==================== -->
<section id="habilidades">
    <div class="container text-center">
        <h2 class="section-title">Habilidades y Herramientas</h2>
        <p class="section-subtitle">Tecnologías y herramientas que domino en el desarrollo web</p>
        <div class="row g-3 justify-content-center">
            <?php foreach ($habilidades as $h): ?>
            <div class="col-6 col-sm-4 col-md-3">
                <div class="habilidad-card">
                    <div class="habilidad-icon-circle" style="background:<?= htmlspecialchars($h['color']) ?>22;color:<?= htmlspecialchars($h['color']) ?>">
                        <i class="bi <?= htmlspecialchars($h['icono']) ?>"></i>
                    </div>
                    <p class="habilidad-nombre"><?= htmlspecialchars($h['nombre']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== TECNOLOGÍAS ==================== -->
<section id="tecnologias">
    <div class="container text-center">
        <h2 class="section-title">Tecnologías Dominadas</h2>
        <p class="section-subtitle">Nivel de experiencia en diferentes tecnologías web</p>
        <div class="row g-3">
            <?php foreach ($tecnologias as $t): ?>
            <div class="col-6 col-md-3">
                <div class="tech-card text-start">
                    <p class="tech-nombre"><?= htmlspecialchars($t['nombre']) ?></p>
                    <p class="tech-pct"><?= (int)$t['porcentaje'] ?>%</p>
                    <div class="progress">
                        <div class="progress-bar"
                             data-width="<?= (int)$t['porcentaje'] ?>"
                             style="width:0%;background:<?= htmlspecialchars($t['color']) ?>"
                             role="progressbar"
                             aria-valuenow="<?= (int)$t['porcentaje'] ?>"
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== PROYECTOS ==================== -->
<section id="proyectos">
    <div class="container text-center">
        <h2 class="section-title">Proyectos Realizados</h2>
        <p class="section-subtitle">Algunos de los proyectos web que he desarrollado</p>
        <div class="row g-4 text-start">
            <?php
            $emojis = ['📚','🛒','✏️','📊'];
            $ei = 0;
            foreach ($proyectos as $p):
                $tags = array_filter(array_map('trim', explode(',', $p['tecnologias_usadas'] ?? '')));
            ?>
            <div class="col-12 col-md-6">
                <div class="proyecto-card">
                    <div class="proyecto-img-wrapper">
                        <?php if (!empty($p['imagen']) && file_exists($p['imagen'])): ?>
                            <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['titulo']) ?>">
                        <?php else: ?>
                            <span class="proyecto-img-placeholder"><?= $emojis[$ei % count($emojis)] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="proyecto-body">
                        <h3 class="proyecto-titulo"><?= htmlspecialchars($p['titulo']) ?></h3>
                        <p class="proyecto-desc"><?= htmlspecialchars($p['descripcion']) ?></p>
                        <div class="tech-tags">
                            <?php foreach ($tags as $tag): ?>
                            <span class="tech-tag"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?= htmlspecialchars($p['url_demo'] ?? '#') ?>" class="btn-demo" target="_blank">
                                <i class="bi bi-box-arrow-up-right"></i> Ver Demo
                            </a>
                            <a href="<?= htmlspecialchars($p['url_github'] ?? '#') ?>" class="btn-repo" target="_blank">
                                <i class="bi bi-github"></i> Repositorio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php $ei++; endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== CONTACTO ==================== -->
<section id="contacto">
    <div class="container text-center">
        <h2 class="section-title">Formulario de Contacto</h2>
        <p class="section-subtitle">¿Tienes algún proyecto en mente? Contáctame</p>
        <div class="row g-4 text-start mt-1">
            <!-- Formulario -->
            <div class="col-12 col-lg-6">
                <div class="contacto-form-card">
                    <div id="contactoAlert" style="display:none;"></div>
                    <form id="contactoForm" novalidate>
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-person"></i> Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Tu nombre completo" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-envelope"></i> Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" placeholder="tu@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-chat-left-text"></i> Asunto</label>
                            <input type="text" name="asunto" class="form-control" placeholder="Asunto del mensaje" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-chat-left-text"></i> Mensaje</label>
                            <textarea name="mensaje" class="form-control" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
                        </div>
                        <button type="submit" class="btn-enviar">
                            <i class="bi bi-send"></i> Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
            <!-- Mapa -->
            <div class="col-12 col-lg-6">
                <div class="mapa-card">
                    <div class="mapa-header">
                        <i class="bi bi-geo-alt-fill" style="color: var(--green)"></i>
                        Temuco, Chile
                    </div>
                    <iframe
                        class="mapa-iframe"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d49782.57!2d-72.6344!3d-38.7359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9614d2e1d89c3e0d%3A0x1e2b0a4e3c7f4b5a!2sTemuco%2C%20Araucan%C3%ADa%2C%20Chile!5e0!3m2!1ses!2scl!4v1"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ========== Footer =========-->
<footer>
    <div class="container">
        <p>© <?= date('Y') ?> <span><?= htmlspecialchars($biografia['nombre']) ?></span> — Portafolio Web Profesional</p>
        <p class="mt-1" style="font-size:0.82rem;">Desarrollado con HTML5, CSS3, Bootstrap 5, JavaScript, PHP y MySQL</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>