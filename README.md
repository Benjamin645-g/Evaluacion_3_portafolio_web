# Portafolio Web Profesional Autoadministrable

**Estudiante:** Benjamin Pacheco   
**Evaluación:** Evaluación 3 — Portafolio Web  

---

## Proyecto en Producción

[https://teclab.uct.cl/~bpacheco2025/](https://teclab.uct.cl/~bpacheco2025/)

---

## Descripción

Portafolio web dinámico y autoadministrable desarrollado con tecnologías frontend y backend. Permite visualizar y gestionar información mediante un sistema de administración con autenticación segura.

---

## Funcionalidades

- **Biografía** — Información personal y profesional editable desde el dashboard
- **Habilidades** — Tecnologías dominadas con íconos y colores dinámicos
- **Tecnologías** — Barras de progreso animadas con nivel de experiencia
- **Proyectos** — Tarjetas con descripción, tecnologías, demo y GitHub
- **Formulario de contacto** — Envío de mensajes con AJAX y almacenamiento en BD
- **Sistema de login** — Autenticación segura con hash bcrypt
- **Dashboard administrativo** — CRUD completo para gestionar todo el contenido

---

## Diseño en Figma
El portafolio se desarrolló en base al siguiente wireframe/diseño:
[Ver diseño en Figma](https://kilt-real-11993237.figma.site)

---
## Tecnologías Utilizadas

| Tecnología | Uso |
|-----------|-----|
| HTML5 | Estructura semántica |
| CSS3 | Estilos personalizados |
| Bootstrap 5.3 | Diseño responsive |
| JavaScript | Interactividad y AJAX |
| PHP | Backend y lógica del servidor |
| MySQL | Base de datos |
| PDO | Conexión segura a BD |

---

## Estructura del Proyecto

```
EVALUACION_3_PORTAFOLIO/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── img/
│   │   └── Foto.jpg
│   └── js/
│       └── script.js
├── dashboard/
│   ├── _sidebar.php
│   ├── index.php
│   ├── biografia.php
│   ├── habilidades.php
│   ├── tecnologias.php
│   ├── proyectos.php
│   └── mensajes.php
├── includes/
│   ├── db.php
│   └── functions.php
├── index.php
├── login.php
├── logout.php
├── contacto.php
├── bd.sql
└── README.md
```

---



## Credenciales de Acceso

| Campo | Valor |
|-------|-------|
| Usuario | `admin` |
| Contraseña | `password` |

---

## Herramientas de IA Utilizadas

- **Claude** — Apoyo en desarrollo, corrección de bugs y buenas prácticas

---

## Autor

**Benjamin Pacheco**  
benjaminmatiasps@gmail.com  
Temuco, Chile