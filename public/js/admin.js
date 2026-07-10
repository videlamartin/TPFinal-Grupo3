// Reportes del panel de administración.
// Usa Chart.js. Los datos vienen desde la vista (window.grafico*).
// Los colores se leen de las variables CSS de quizmaster.css, así los
// gráficos se adaptan solos al modo claro y oscuro.

const params = new URLSearchParams(window.location.search);
const periodo = params.get("periodo");
if (periodo) {
    const select = document.querySelector('select[name="periodo"]');
    if (select) select.value = periodo;
}

// ----- Colores desde el sistema de diseño -----
const css    = getComputedStyle(document.documentElement);
const cVar    = (name, fallback) => (css.getPropertyValue(name).trim() || fallback);

const COLOR_MARCA  = cVar('--qm-brand', '#6D3BEF');
const COLOR_TEXTO  = cVar('--qm-ink-soft', '#4A4463');
const COLOR_GRID   = cVar('--qm-border', '#E6E3F2');

// Paleta para los gráficos de barras (colores de categoría del juego)
const PALETA_BARRAS = [
    cVar('--qm-cat-geografia', '#1E88E5'),
    cVar('--qm-cat-ciencia', '#35A65A'),
    cVar('--qm-cat-historia', '#F2B90C'),
    cVar('--qm-cat-deportes', '#FB8C00'),
    cVar('--qm-cat-entretenimiento', '#8E24AA'),
    cVar('--qm-cat-arte', '#E5393B'),
];

function hexAlpha(hex, alpha) {
    const h = hex.replace('#', '');
    if (h.length !== 6) return hex;
    const r = parseInt(h.slice(0, 2), 16);
    const g = parseInt(h.slice(2, 4), 16);
    const b = parseInt(h.slice(4, 6), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

// Opciones comunes a todos los gráficos
function opcionesBase() {
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0, color: COLOR_TEXTO },
                grid:  { color: COLOR_GRID }
            },
            x: {
                ticks: { color: COLOR_TEXTO },
                grid:  { display: false }
            }
        }
    };
}

function graficoLinea(canvasId, datos, campoLabel, campoValor) {
    const el = document.getElementById(canvasId);
    if (!el) return;
    new Chart(el, {
        type: 'line',
        data: {
            labels: datos.map(d => d[campoLabel]),
            datasets: [{
                data: datos.map(d => Number(d[campoValor])),
                borderColor: COLOR_MARCA,
                backgroundColor: hexAlpha(COLOR_MARCA, 0.13),
                pointBackgroundColor: COLOR_MARCA,
                borderWidth: 2.5,
                pointRadius: 3,
                fill: true,
                tension: 0.3
            }]
        },
        options: opcionesBase()
    });
}

function graficoBarras(canvasId, datos, campoLabel, campoValor) {
    const el = document.getElementById(canvasId);
    if (!el) return;
    new Chart(el, {
        type: 'bar',
        data: {
            labels: datos.map(d => d[campoLabel]),
            datasets: [{
                data: datos.map(d => Number(d[campoValor])),
                backgroundColor: datos.map((_, i) => PALETA_BARRAS[i % PALETA_BARRAS.length]),
                borderRadius: 6,
                maxBarThickness: 60
            }]
        },
        options: opcionesBase()
    });
}

// ----- Creación de los 6 gráficos -----
graficoLinea('usuariosChart',    JSON.parse(window.graficoUsuarios),  'periodo', 'total');
graficoLinea('partidasChart',    JSON.parse(window.graficoPartidas),  'periodo', 'total');
graficoLinea('graficoPreguntas', JSON.parse(window.graficoPreguntas), 'periodo', 'total');

graficoBarras('usuariosPaisChart', JSON.parse(window.usuariosPorPais), 'pais',  'total');
graficoBarras('usuariosSexoChart', JSON.parse(window.usuariosPorSexo), 'sexo',  'total');
graficoBarras('usuariosEdadChart', JSON.parse(window.usuariosPorEdad), 'grupo', 'total');
