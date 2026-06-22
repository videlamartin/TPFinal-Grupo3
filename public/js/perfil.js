document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('mapa-perfil');

    if (!container) return;

    const ciudad = container.dataset.ciudad;
    const pais = container.dataset.pais;

    console.log("Ciudad:", ciudad);
    console.log("País:", pais);

    if (!ciudad && !pais) {
        container.innerHTML = "No hay ubicación registrada";
        return;
    }

    fetch(`https://nominatim.openstreetmap.org/search?city=${encodeURIComponent(ciudad)}&country=${encodeURIComponent(pais)}&format=json`)
        .then(res => res.json())
        .then(data => {
            console.log(data);

            if (!data.length) {
                container.innerHTML = "No se pudo ubicar en el mapa";
                return;
            }

            const lat = parseFloat(data[0].lat);
            const lng = parseFloat(data[0].lon);

            const map = L.map('mapa-perfil').setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup(`${ciudad}, ${pais}`)
                .openPopup();
        })
        .catch(console.error);
});