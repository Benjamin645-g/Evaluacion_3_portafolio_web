-- Crear base de datos
CREATE DATABASE IF NOT EXISTS portafolio
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE portafolio;

-- Tabla Biografía
CREATE TABLE biografia (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100),
  descripcion TEXT,
  correo VARCHAR(100),
  ubicacion VARCHAR(100),
  estado VARCHAR(50)
);

INSERT INTO biografia (nombre, descripcion, correo, ubicacion, estado)
VALUES ('Benjamin Pacheco', 'Desarrollador Web Full Stack', 'benjaminmatiasps@gmail.com', 'Temuco, Chile', 'Disponible');

-- Tabla Habilidades
CREATE TABLE habilidades (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100)
);

INSERT INTO habilidades (nombre) VALUES
('HTML'), ('CSS'), ('JavaScript'), ('PHP'), ('MySQL'), ('Bootstrap'), ('GitHub'), ('IA Aplicada');

-- Tabla Tecnologías
CREATE TABLE tecnologias (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100),
  porcentaje INT
);

INSERT INTO tecnologias (nombre, porcentaje) VALUES
('HTML/CSS', 95),
('JavaScript', 85),
('PHP', 80),
('MySQL', 75),
('Bootstrap', 90),
('React', 70),
('Git/GitHub', 85),
('Diseño Responsive', 90);

-- Tabla Proyectos
CREATE TABLE proyectos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(150),
  descripcion TEXT,
  demo VARCHAR(255),
  repo VARCHAR(255)
);

INSERT INTO proyectos (titulo, descripcion, demo, repo) VALUES
('Sistema de Gestión Escolar', 'Plataforma web para gestión de estudiantes, notas y asistencia. Desarrollado con PHP, MySQL y Bootstrap.', 'demo_link_1', 'repo_link_1'),
('E-commerce Responsive', 'Tienda online con carrito de compras, sistema de pagos y panel administrativo completo.', 'demo_link_2', 'repo_link_2'),
('Blog Personal', 'Blog con sistema de publicaciones, comentarios y gestión de usuarios. Diseño moderno y responsive.', 'demo_link_3', 'repo_link_3'),
('Dashboard Analítico', 'Panel de control con gráficos interactivos y visualización de datos en tiempo real.', 'demo_link_4', 'repo_link_4');

-- Tabla Mensajes (formulario de contacto)
CREATE TABLE mensajes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100),
  correo VARCHAR(100),
  asunto VARCHAR(150),
  mensaje TEXT,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
