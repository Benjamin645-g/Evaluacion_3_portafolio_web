<?php
session_start();
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Portafolio</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Benjamin Pacheco</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#biografia">Biografía</a></li>
        <li class="nav-item"><a class="nav-link" href="#habilidades">Habilidades</a></li>
        <li class="nav-item"><a class="nav-link" href="#tecnologias">Tecnologías</a></li>
        <li class="nav-item"><a class="nav-link" href="#proyectos">Proyectos</a></li>
        <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
        <li class="nav-item">
          <a class="btn btn-success" href="login.php">Inicio de Sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Biografía -->
<section id="biografia" class="container mt-5 pt-5 text-center">
  <img src="assets/img/Foto.jpg" class="rounded-circle" width="150" alt="Foto">
  <h1>Benjamin Pacheco</h1>
  <h3>Desarrollador Web Full Stack</h3>
  <p>Estudiante apasionado por el desarrollo web, con experiencia en diseño y programación de sitios web modernos y responsivos.</p>
  <p>📧 benjaminmatiasps@gmail.com | 📍 Temuco, Chile | 📅 Disponible</p>
</section>

<!-- Habilidades -->
<section id="habilidades" class="container mt-5">
  <h2>Habilidades y Herramientas</h2>
  <div class="row text-center">
    <div class="col">HTML</div>
    <div class="col">CSS</div>
    <div class="col">JavaScript</div>
    <div class="col">PHP</div>
    <div class="col">MySQL</div>
    <div class="col">Bootstrap</div>
    <div class="col">GitHub</div>
    <div class="col">IA Aplicada</div>
  </div>
</section>

<!-- Tecnologías -->
<section id="tecnologias" class="container mt-5">
  <h2>Tecnologías Dominadas</h2>
  <div class="mb-3">HTML/CSS <div class="progress"><div class="progress-bar" style="width:95%">95%</div></div></div>
  <div class="mb-3">JavaScript <div class="progress"><div class="progress-bar bg-success" style="width:85%">85%</div></div></div>
  <div class="mb-3">PHP <div class="progress"><div class="progress-bar bg-info" style="width:80%">80%</div></div></div>
  <div class="mb-3">MySQL <div class="progress"><div class="progress-bar bg-warning" style="width:75%">75%</div></div></div>
  <div class="mb-3">Bootstrap <div class="progress"><div class="progress-bar bg-danger" style="width:90%">90%</div></div></div>
  <div class="mb-3">React <div class="progress"><div class="progress-bar bg-primary" style="width:70%">70%</div></div></div>
  <div class="mb-3">Git/GitHub <div class="progress"><div class="progress-bar bg-secondary" style="width:85%">85%</div></div></div>
  <div class="mb-3">Diseño Responsive <div class="progress"><div class="progress-bar bg-dark" style="width:90%">90%</div></div></div>
</section>

<!-- Proyectos -->
<section id="proyectos" class="container mt-5">
  <h2>Proyectos Realizados</h2>
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5>Sistema de Gestión Escolar</h5>
          <p>Plataforma web para gestión de estudiantes, notas y asistencia.</p>
          <p><span class="badge bg-primary">PHP</span> <span class="badge bg-success">MySQL</span> <span class="badge bg-info">Bootstrap</span></p>
          <a href="#" class="btn btn-success">Ver Demo</a>
          <a href="#" class="btn btn-dark">Repositorio</a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5>E-commerce Responsive</h5>
          <p>Tienda online con carrito de compras y sistema de pagos.</p>
          <p><span class="badge bg-primary">PHP</span> <span class="badge bg-warning">JavaScript</span> <span class="badge bg-info">AJAX</span></p>
          <a href="#" class="btn btn-success">Ver Demo</a>
          <a href="#" class="btn btn-dark">Repositorio</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contacto -->
<section id="contacto" class="container mt-5">
  <h2>Formulario de Contacto</h2>
  <form action="contacto.php" method="POST">
    <div class="mb-3">
      <input type="text" name="nombre" class="form-control" placeholder="Tu nombre completo" required>
    </div>
    <div class="mb-3">
      <input type="email" name="correo" class="form-control" placeholder="tu@email.com" required>
    </div>
    <div class="mb-3">
      <input type="text" name="asunto" class="form-control" placeholder="Asunto del mensaje" required>
    </div>
    <div class="mb-3">
      <textarea name="mensaje" class="form-control" placeholder="Escribe tu mensaje aquí..." required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Enviar Mensaje</button>
  </form>
  <!-- Aquí puedes insertar el mapa embebido -->
  <iframe src="https://www.google.com/maps?q=Temuco,+Chile&output=embed" width="100%" height="300" style="border:0;"></iframe>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
