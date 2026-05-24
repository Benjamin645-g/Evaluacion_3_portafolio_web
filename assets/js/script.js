// ============================================
// assets/js/script.js - Portafolio Benjamin Pacheco
// ============================================

document.addEventListener('DOMContentLoaded', function () {

    // ---- Animación de barras de progreso al hacer scroll ----
    const animateProgressBars = () => {
        document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
            const rect = bar.closest('.tech-card').getBoundingClientRect();
            if (rect.top < window.innerHeight - 60 && !bar.classList.contains('animated')) {
                bar.style.width = bar.getAttribute('data-width') + '%';
                bar.classList.add('animated');
            }
        });
    };
    window.addEventListener('scroll', animateProgressBars);
    animateProgressBars(); // Ejecutar al cargar por si ya está visible

    // ---- Navbar: active link on scroll ----
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 90;
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    });

    // ---- Formulario de contacto con AJAX ----
    const form = document.getElementById('contactoForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = form.querySelector('.btn-enviar');
            const alertBox = document.getElementById('contactoAlert');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

            const formData = new FormData(form);

            fetch('contacto.php', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                alertBox.style.display = 'block';
                if (data.success) {
                    alertBox.className = 'alert-success-custom';
                    alertBox.innerHTML = '<i class="bi bi-check-circle me-2"></i>' + data.message;
                    form.reset();
                } else {
                    alertBox.className = 'alert-error-custom';
                    alertBox.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>' + data.message;
                }
                setTimeout(() => { alertBox.style.display = 'none'; }, 5000);
            })
            .catch(() => {
                alertBox.className = 'alert-error-custom';
                alertBox.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Error al enviar. Intenta nuevamente.';
                alertBox.style.display = 'block';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-send me-2"></i>Enviar Mensaje';
            });
        });
    }

    // ---- Sidebar toggle (mobile dashboard) ----
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });
    }

    // ---- Auto-hide alerts after 4s ----
    document.querySelectorAll('.auto-hide-alert').forEach(alert => {
        setTimeout(() => { alert.style.opacity = '0'; setTimeout(() => alert.remove(), 400); }, 4000);
    });

    // ---- Animación fade-in al cargar secciones ----
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.08 });

    document.querySelectorAll('.habilidad-card, .tech-card, .proyecto-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(24px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });

    // Agregar clase visible con CSS
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            .habilidad-card.visible, .tech-card.visible, .proyecto-card.visible {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }
        </style>
    `);
});