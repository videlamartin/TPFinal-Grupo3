// Modo oscuro / claro.
// El tema elegido se guarda en el navegador (localStorage) y se aplica
// en TODAS las páginas apenas cargan (para que no haya parpadeo).
// Si el usuario nunca eligió, la app sigue el tema del sistema operativo.

(function () {
    var guardado = localStorage.getItem('qm-tema');
    if (guardado) {
        document.documentElement.setAttribute('data-theme', guardado);
    }
})();

function qmTemaEsOscuro() {
    var actual = document.documentElement.getAttribute('data-theme');
    if (actual) return actual === 'dark';
    // Sin elección previa: mirar la preferencia del sistema.
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function qmCambiarTema() {
    var nuevo = qmTemaEsOscuro() ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', nuevo);
    localStorage.setItem('qm-tema', nuevo);
    qmActualizarIconoTema();
}

function qmActualizarIconoTema() {
    var btn = document.getElementById('qm-tema-btn');
    if (!btn) return;
    // Muestra el ícono de lo que se va a activar al tocar.
    btn.textContent = qmTemaEsOscuro() ? '☀️' : '🌙';
    btn.setAttribute('title', qmTemaEsOscuro() ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro');
}

document.addEventListener('DOMContentLoaded', qmActualizarIconoTema);
