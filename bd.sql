CREATE DATABASE IF NOT EXISTS portafolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portafolio_db;

-- ============================================
-- TABLA: usuarios (login administrativo)
-- ============================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario admin por defecto: admin / password
INSERT INTO usuarios (username, password, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uXkuPHb6K', 'benjaminmatiasps@gmail.com');
-- Nota: password es 'password' hasheado. Cambiar en producción.

-- ============================================
-- TABLA: biografia
-- ============================================
CREATE TABLE IF NOT EXISTS biografia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    titulo VARCHAR(150),
    descripcion TEXT,
    email VARCHAR(100),
    ubicacion VARCHAR(100),
    disponibilidad VARCHAR(50),
    foto VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO biografia (nombre, titulo, descripcion, email, ubicacion, disponibilidad, foto) VALUES
('Benjamin Pacheco', 'Desarrollador Web Full Stack',
'Estudiante apasionado por el desarrollo web, con experiencia en diseño y programación de sitios web modernos y responsivos. Especializado en crear soluciones digitales innovadoras utilizando las últimas tecnologías del mercado.',
'benjaminmatiasps@gmail.com', 'Temuco, Chile', 'Disponible', 'assets/img/Foto.jpg');

-- ============================================
-- TABLA: habilidades
-- ============================================
CREATE TABLE IF NOT EXISTS habilidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    icono VARCHAR(100),
    color VARCHAR(20) DEFAULT '#1a2332',
    orden INT DEFAULT 0,
    activo TINYINT(1) DEFAULT 1
);

INSERT INTO habilidades (nombre, icono, color, orden) VALUES
('HTML', 'bi-code-slash', '#e34f26', 1),
('CSS', 'bi-palette', '#264de4', 2),
('JavaScript', 'bi-globe', '#f7df1e', 3),
('PHP', 'bi-server', '#777bb4', 4),
('MySQL', 'bi-database', '#1a9650', 5),
('Bootstrap', 'bi-layout-sidebar', '#7952b3', 6),
('GitHub', 'bi-git', '#1a2332', 7),
('IA Aplicada', 'bi-cpu', '#1a9650', 8);

-- ============================================
-- TABLA: tecnologias
-- ============================================
CREATE TABLE IF NOT EXISTS tecnologias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    porcentaje INT NOT NULL DEFAULT 0,
    color VARCHAR(20) DEFAULT '#1a9650',
    orden INT DEFAULT 0,
    activo TINYINT(1) DEFAULT 1
);

INSERT INTO tecnologias (nombre, porcentaje, color, orden) VALUES
('HTML/CSS', 95, '#1a9650', 1),
('JavaScript', 85, '#1a9650', 2),
('PHP', 80, '#1a2332', 3),
('MySQL', 75, '#1a2332', 4),
('Bootstrap', 90, '#1a9650', 5),
('React', 70, '#1a2332', 6),
('Git/GitHub', 85, '#1a2332', 7),
('Diseño Responsive', 90, '#1a9650', 8);

-- ============================================
-- TABLA: proyectos
-- ============================================
CREATE TABLE IF NOT EXISTS proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    url_demo VARCHAR(255),
    url_github VARCHAR(255),
    tecnologias_usadas VARCHAR(255),
    orden INT DEFAULT 0,
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO proyectos (titulo, descripcion, imagen, url_demo, url_github, tecnologias_usadas, orden) VALUES
('Sistema de Gestión Escolar', 'Plataforma web para gestión de estudiantes, notas y asistencia. Desarrollado con PHP, MySQL y Bootstrap.', 'assets/img/proyecto1.jpg', '#', '#', 'PHP,MySQL,Bootstrap', 1),
('E-commerce Responsive', 'Tienda online con carrito de compras, sistema de pagos y panel administrativo completo.', 'assets/img/proyecto2.jpg', '#', '#', 'PHP,JavaScript,AJAX', 2),
('Blog Personal', 'Blog con sistema de publicaciones, comentarios y gestión de usuarios. Diseño moderno y responsive.', 'assets/img/proyecto3.jpg', '#', '#', 'PHP,MySQL,CSS', 3),
('Dashboard Analítico', 'Panel de control con gráficos interactivos y visualización de datos en tiempo real.', 'assets/img/proyecto4.jpg', '#', '#', 'JavaScript,PHP,Chart.js', 4);

-- ============================================
-- TABLA: contacto (mensajes recibidos)
-- ============================================
CREATE TABLE IF NOT EXISTS contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    asunto VARCHAR(150),
    mensaje TEXT NOT NULL,
    leido TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);