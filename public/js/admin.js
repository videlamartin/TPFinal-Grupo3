const params = new URLSearchParams(window.location.search);
const periodo = params.get("periodo");

if (periodo) {
    const select = document.querySelector('select[name="periodo"]');
    if (select) select.value = periodo;
}

// ===== USUARIOS =====
const dataUsuarios = JSON.parse(window.graficoUsuarios);

const labelsUsuarios = dataUsuarios.map(d => d.periodo);
const valoresUsuarios = dataUsuarios.map(d => d.total);

new Chart(document.getElementById('usuariosChart'), {
    type: 'line',
    data: {
        labels: labelsUsuarios,
        datasets: [{
            data: valoresUsuarios,
            fill: false,
            tension: 0.3
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Usuarios registrados',
                color: 'black',
                font: {
                    size: 30,
                    weight: 'bold',
                }
            },
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0, color: 'black' }
            },
            x: {
                ticks: { color: 'black' }
            }
        }
    }
});

// ===== PARTIDAS =====
const dataPartidas = JSON.parse(window.graficoPartidas);

const labelsPartidas = dataPartidas.map(d => d.periodo);
const valoresPartidas = dataPartidas.map(d => d.total);

new Chart(document.getElementById('partidasChart'), {
    type: 'line',
    data: {
        labels: labelsPartidas,
        datasets: [{
            data: valoresPartidas,
            fill: false,
            tension: 0.3
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Partidas jugadas',
                color: 'black',
                font: {
                    size: 30,
                    weight: 'bold',
                }
            },
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0, color: 'black' }
            },
            x: {
                ticks: { color: 'black' }
            }
        }
    }
});