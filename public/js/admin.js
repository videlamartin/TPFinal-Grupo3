const params = new URLSearchParams(window.location.search);
const periodo = params.get("periodo");

if (periodo) {
    const select = document.querySelector('select[name="periodo"]');
    if (select) select.value = periodo;
}

// ===== USUARIOS REGISTRADOS=====
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
            legend: {display: false}
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {precision: 0, color: 'black'}
            },
            x: {
                ticks: {color: 'black'}
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
            legend: {display: false}
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {precision: 0, color: 'black'}
            },
            x: {
                ticks: {color: 'black'}
            }
        }
    }
});

// ===== PREGUNTAS =====
const preguntas = JSON.parse(window.graficoPreguntas);

new Chart(document.getElementById('graficoPreguntas'), {
    type: 'line',
    data: {
        labels: preguntas.map(p => p.periodo),
        datasets: [{
            label: 'Preguntas en el juego',
            data: preguntas.map(p => p.total),
            fill: false,
            tension: 0.3
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Preguntas totales',
                color: 'black',
                font: {
                    size: 30,
                    weight: 'bold',
                }
            },
            legend: {display: false}
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {precision: 0, color: 'black'}
            },
            x: {
                ticks: {color: 'black'}
            }
        }
    }
});


// ===== USUARIOS POR PAIS=====
const usuariosPais = JSON.parse(window.usuariosPorPais);

new Chart(document.getElementById('usuariosPaisChart'), {
    type: 'bar',
    data: {
        labels: usuariosPais.map(u => u.pais),
        datasets: [{
            label: 'Usuarios por país',
            data: usuariosPais.map(u => u.total),
            barPercentage: 0.3,
            categoryPercentage: 0.4
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Usuarios por país',
                color: 'black',
                font: {
                    size: 30,
                    weight: 'bold',
                }
            },
            legend: {display: false}
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {precision: 0, color: 'black'}
            },
            x: {
                ticks: {color: 'black'}
            }
        }
    }
});

// ===== USUARIOS POR SEXO=====
const usuariosSexo = JSON.parse(window.usuariosPorSexo);

new Chart(document.getElementById('usuariosSexoChart'), {
    type: 'bar',
    data: {
        labels: usuariosSexo.map(u => u.sexo),
        datasets: [{
            label: 'Usuarios por sexo',
            data: usuariosSexo.map(u => u.total),
            barPercentage: 0.5,
            categoryPercentage: 0.6
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Usuarios por sexo',
                color: 'black',
                font: {
                    size: 30,
                    weight: 'bold',
                }
            },
            legend: {display: false}
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {precision: 0, color: 'black'}
            },
            x: {
                ticks: {color: 'black'}
            }
        }
    }
});

// ===== USUARIOS POR EDAD =====

const usuariosEdad = JSON.parse(window.usuariosPorEdad);

usuariosEdad.forEach(u => {
    u.total = Number(u.total);
});

console.log(usuariosEdad);

new Chart(document.getElementById('usuariosEdadChart'), {
    type: 'bar',
    data: {
        labels: usuariosEdad.map(u => u.grupo),
        datasets: [{
            label: 'Usuarios',
            data: usuariosEdad.map(u => u.total),
            barPercentage: 0.5,
            categoryPercentage: 0.6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Usuarios por grupo de edad',
                color: 'black',
                font: {
                    size: 30,
                    weight: 'bold'
                }
            },
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0,
                    color: 'black'
                }
            },
            x: {
                ticks: {
                    color: 'black'
                }
            }
        }
    }
});
