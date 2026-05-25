# Documento de Uso de Inteligencia Artificial

**Estudiante:** Benjamin Pacheco  
**Proyecto:** Portafolio Web Profesional Autoadministrable  
**Evaluación:** Evaluación 3  
**Fecha:** Mayo 2026  

---

## 1. Herramientas de IA Utilizadas

| Herramienta | Plataforma | Uso Principal |
|------------|-----------|---------------|
| **Claude** | claude.ai | Desarrollo de código, corrección de bugs, buenas prácticas, consultas técnicas y organización de estructura de archivos |

---

## 2. Prompts Utilizados

### Prompt 1 — Estructura del proyecto
> *"Necesito crear un portafolio web autoadministrable con PHP y MySQL. ¿Cómo organizo la estructura de carpetas?"*

### Prompt 2 — Conexión a base de datos
> *"Ayúdame a crear un archivo db.php con conexión PDO a MySQL con manejo de errores."*

### Prompt 3 — Sistema de login seguro
> *"Crea un login.php que verifique usuario y contraseña contra una base de datos usando password_verify() y sesiones PHP."*

### Prompt 4 — Estilo del portafolio
> *"Ayúdame a crear el estilo CSS de mi portafolio para que sea coherente con el diseño en Figma."*

### Prompt 5 — Corrección de bug en modal
> *"Cuando aprieto el botón ver mensajes queda en blanco el modal. El código usa addslashes y htmlspecialchars juntos en el onclick."*

### Prompt 6 — Dashboard administrativo
> *"Crea un dashboard/biografia.php que lea los datos desde MySQL y permita editarlos con un formulario que haga UPDATE en la BD."*

### Prompt 7 — Animaciones con JavaScript
> *"¿Cómo animo barras de progreso con JavaScript cuando el usuario hace scroll hasta verlas?"*

---

## 3. Resultados Generados

### Código generado con apoyo de IA:

**Conexión PDO segura (`db.php`)**
```php
$pdo = new PDO(
    "mysql:host=localhost;dbname=portafolio_db;charset=utf8mb4",
    DB_USER, DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
```

**Verificación de login contra BD**
```php
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? LIMIT 1");
$stmt->execute([$username]);
$user = $stmt->fetch();
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['admin_logged_in'] = true;
}
```

**Corrección del modal (bug data-* vs onclick)**
```javascript
document.querySelectorAll('.btn-ver-msg').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var d = this.dataset;
        document.getElementById('modal_nombre').textContent = d.nombre;
    });
});
```

**Animación de barras de progreso**
```javascript
const animateProgressBars = () => {
    document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
        const rect = bar.closest('.tech-card').getBoundingClientRect();
        if (rect.top < window.innerHeight - 60 && !bar.classList.contains('animated')) {
            bar.style.width = bar.getAttribute('data-width') + '%';
            bar.classList.add('animated');
        }
    });
};
```

---

## 4. Ajustes Realizados

La IA generó código base que luego fue modificado manualmente:

- **Credenciales de BD** — Se ajustaron los datos de conexión según el servidor Teclab.
- **Estilos CSS** — Se personalizaron colores y tipografías según el diseño del wireframe.
- **Estructura HTML** — Se reorganizaron secciones para mantener coherencia con el diseño Figma.
- **Bug del modal** — Claude identificó el problema del doble escape (`addslashes` + `htmlspecialchars`) y propuso la solución con atributos `data-*`.
- **Datos hardcodeados** — Los archivos PHP originalmente tenían datos fijos en arrays; Claude los reemplazó por consultas reales a la BD.
- **Sidebar duplicado** — Se refactorizó extrayendo el sidebar a un archivo `_sidebar.php` reutilizable.

---

## 5. Reflexión Crítica

### Utilidad
Claude fue especialmente útil para identificar errores difíciles de detectar a simple vista, como el bug del modal causado por el doble escape de caracteres. También aceleró el desarrollo del backend al generar código PHP seguro con PDO preparado y explicar cada decisión técnica.

### Ventajas
- Ahorra tiempo en tareas repetitivas como crear formularios CRUD.
- Explica el código generado, lo que facilita el aprendizaje.
- Detecta bugs y sugiere correcciones con explicación del porqué.

### Limitaciones
- No conoce el contexto visual del proyecto, por lo que el diseño y CSS requirieron trabajo manual.
- A veces genera código que hay que adaptar al servidor específico (credenciales, rutas).

### Aprendizaje Obtenido
El uso de Claude como apoyo al desarrollo enseña a formular preguntas precisas y a evaluar críticamente el código recibido. La IA es una herramienta de apoyo, no un reemplazo del desarrollador: el criterio, la revisión y la adaptación del código siempre recaen en el estudiante.

---