let pasoActual = 1;
const totalPasos = 3;

window.addEventListener('DOMContentLoaded', function () {
    const errorServer = document.getElementById('error-server');
    if (errorServer) irAPasoSilencioso(3);
});

function mostrarError(msg) {
    const box = document.getElementById('error-cliente');
    box.textContent = '⚠ ' + msg;
    box.style.display = 'block';
    setTimeout(() => box.style.display = 'none', 4000);
}

function irAPasoSilencioso(nuevoPaso) {
    document.getElementById('paso-' + pasoActual).classList.remove('activo');
    document.getElementById('step-ind-' + pasoActual).classList.remove('activo');
    if (nuevoPaso > pasoActual) document.getElementById('step-ind-' + pasoActual).classList.add('completado');
    pasoActual = nuevoPaso;
    document.getElementById('paso-' + pasoActual).classList.add('activo');
    document.getElementById('step-ind-' + pasoActual).classList.add('activo');
    actualizarLineas();
}

function irAPaso(nuevoPaso) {
    if (nuevoPaso > pasoActual && !validarPaso(pasoActual)) return;
    document.getElementById('paso-' + pasoActual).classList.remove('activo');
    document.getElementById('step-ind-' + pasoActual).classList.remove('activo');
    if (nuevoPaso > pasoActual) {
        document.getElementById('step-ind-' + pasoActual).classList.add('completado');
    } else {
        document.getElementById('step-ind-' + pasoActual).classList.remove('completado');
    }
    pasoActual = nuevoPaso;
    document.getElementById('paso-' + pasoActual).classList.add('activo');
    document.getElementById('step-ind-' + pasoActual).classList.remove('completado');
    document.getElementById('step-ind-' + pasoActual).classList.add('activo');
    actualizarLineas();
    if (pasoActual === 2 && !mapaIniciado) iniciarMapa();
}

function actualizarLineas() {
    for (let i = 1; i < totalPasos; i++) {
        document.getElementById('line-' + i).classList.toggle('completado', i < pasoActual);
    }
}

function validarPaso(paso) {
    if (paso === 1) {
        const nombre = document.getElementById('nombre_completo').value.trim();
        const anio   = document.getElementById('anio_nacimiento').value;
        const sexo   = document.getElementById('sexo').value;
        if (!nombre)                             { mostrarError('Ingresá tu nombre completo'); return false; }
        if (!anio || anio < 1900 || anio > 2010) { mostrarError('Ingresá un año de nacimiento válido'); return false; }
        if (!sexo)                               { mostrarError('Seleccioná una opción de sexo'); return false; }
    }
    if (paso === 2) {
        if (!document.getElementById('pais').value) { mostrarError('Seleccioná tu ubicación en el mapa'); return false; }
    }
    return true;
}

function validarAntesDeEnviar() {
    const username = document.getElementById('username').value.trim();
    const email    = document.getElementById('email').value.trim();
    const pass     = document.getElementById('password').value;
    const pass2    = document.getElementById('repetir_password').value;
    if (!username)       { mostrarError('El nombre de usuario es obligatorio'); return false; }
    if (!email)          { mostrarError('El email es obligatorio'); return false; }
    if (pass.length < 6) { mostrarError('La contraseña debe tener al menos 6 caracteres'); return false; }
    if (pass !== pass2)  {
        mostrarError('Las contraseñas no coinciden');
        document.getElementById('repetir_password').value = '';
        document.getElementById('repetir_password').focus();
        return false;
    }
    return true;
}

document.getElementById('foto_perfil').addEventListener('change', function () {
    const archivo = this.files[0];
    if (!archivo) return;
    const reader = new FileReader();
    reader.onload = e => document.getElementById('preview-foto').innerHTML = '<img src="' + e.target.result + '">';
    reader.readAsDataURL(archivo);
});

const LAT_UNLAM  = -34.6983;
const LNG_UNLAM  = -58.5630;
const ZOOM_UNLAM = 13;
let mapaIniciado = false;
let marcador     = null;

function iniciarMapa() {
    mapaIniciado = true;
    const mapa = L.map('mapa').setView([LAT_UNLAM, LNG_UNLAM], ZOOM_UNLAM);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapa);

    mapa.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        if (marcador) { marcador.setLatLng(e.latlng); } else { marcador = L.marker(e.latlng).addTo(mapa); }
        document.getElementById('latitud').value  = lat.toFixed(6);
        document.getElementById('longitud').value = lng.toFixed(6);
        document.getElementById('texto-ubicacion').textContent = 'Cargando ubicación...';

        fetch('https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json&accept-language=es')
            .then(r => r.json())
            .then(data => {
                const addr   = data.address || {};
                const pais   = addr.country || '';
                const ciudad = addr.city || addr.town || addr.village || addr.county || '';
                document.getElementById('pais').value   = pais;
                document.getElementById('ciudad').value = ciudad;
                const texto = ciudad ? ciudad + ', ' + pais : pais || 'Ubicación seleccionada';
                document.getElementById('texto-ubicacion').textContent = texto;
                marcador.bindPopup(texto).openPopup();
            })
            .catch(() => {
                document.getElementById('pais').value   = 'Desconocido';
                document.getElementById('ciudad').value = 'Desconocido';
                document.getElementById('texto-ubicacion').textContent = 'Ubicación seleccionada';
            });
    });
}