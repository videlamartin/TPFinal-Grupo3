// tiempoTotal y tiempoRestante se inyectan desde la vista antes de cargar este archivo

var numEl   = document.getElementById('timer-num');
var barraEl = document.getElementById('barra-tiempo-fill');
var intervalo;

function pintarTimer() {
    numEl.textContent = tiempoRestante;
    var pct = Math.max(0, (tiempoRestante / tiempoTotal) * 100);
    barraEl.style.width = pct + '%';

    if (tiempoRestante <= 10) {
        barraEl.style.background = '#e53935';
        numEl.classList.add('warning');
    } else if (tiempoRestante <= 20) {
        barraEl.style.background = '#fb8c00';
    }
}

function iniciarTimer() {
    intervalo = setInterval(function () {
        tiempoRestante--;
        pintarTimer();
        if (tiempoRestante <= 0) {
            clearInterval(intervalo);
            document.getElementById('form-timeout').submit();
        }
    }, 1000);
}

function iniciarRuleta() {
    var coloresRuleta = {
        historia: '#e53935',
        deportes: '#43a047',
        ciencia: '#1e88e5',
        arte: '#fb8c00',
        entretenimiento: '#8e24aa',
        geografia: '#fdd835'
    };

    var orden = ['historia','deportes','ciencia','arte','entretenimiento','geografia'];
    var stops = [];
    for (var i = 0; i < orden.length; i++) {
        var c = coloresRuleta[orden[i]];
        stops.push(c + ' ' + (i * 60) + 'deg ' + ((i + 1) * 60) + 'deg');
    }

    var ruleta = document.getElementById('ruleta');
    ruleta.style.background = 'conic-gradient(' + stops.join(', ') + ')';

    var categoriaNormalizada = categoriaActual
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');

    var idx = orden.indexOf(categoriaNormalizada);
    if (idx < 0) idx = 0;

    var anguloCategoria = idx * 60 + 30;
    var anguloFinal = 5 * 360 + (360 - anguloCategoria);

    var overlay     = document.getElementById('ruleta-overlay');
    var ruletaTexto = document.getElementById('ruleta-texto');

    setTimeout(function () {
        ruleta.style.transform = 'rotate(' + anguloFinal + 'deg)';
    }, 200);

    setTimeout(function () {
        ruletaTexto.textContent = '¡' + categoriaActual.toUpperCase() + '!';
        ruletaTexto.style.color = colorActual;
        setTimeout(function () {
            overlay.style.display = 'none';
            pintarTimer();
            iniciarTimer();
        }, 900);
    }, 3300);
}

var preguntaId = document.body.dataset.preguntaId;
var claveRuleta = 'ruleta_' + preguntaId + '_' + categoriaActual;

if (sessionStorage.getItem(claveRuleta)) {
    document.getElementById('ruleta-overlay').style.display = 'none';
    pintarTimer();
    iniciarTimer();
} else {
    sessionStorage.setItem(claveRuleta, '1');
    pintarTimer();
    iniciarRuleta();
}