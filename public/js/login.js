document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    if (!form) return;

    const usernameInput = form.querySelector('input[name="username"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const errorCliente  = document.getElementById("error-cliente");
    const errorServer   = document.getElementById("error-server");

    function mostrarError(msg) {
        errorCliente.textContent = "⚠ " + msg;
        errorCliente.style.display = "block";
        setTimeout(() => errorCliente.style.display = "none", 4000);
    }

    function clearError() {
        errorCliente.style.display = "none";
        errorCliente.textContent = "";
    }

    function validarAntesDeEnviar() {
        const username = usernameInput.value.trim();
        const pass     = passwordInput.value;
        if (!username)       { mostrarError("El usuario es obligatorio");                    usernameInput.focus(); return false; }
        if (!pass)           { mostrarError("La contraseña es obligatoria");                 passwordInput.focus(); return false; }
        if (pass.length < 6) { mostrarError("La contraseña debe tener al menos 6 caracteres"); passwordInput.focus(); return false; }
        return true;
    }

    if (errorServer) {
        const text = errorServer.innerText.trim();
        if (text) mostrarError(text);
    }

    form.addEventListener("submit", (e) => {
        clearError();
        if (!validarAntesDeEnviar()) e.preventDefault();
    });

    [usernameInput, passwordInput].forEach(inp => inp.addEventListener("input", clearError));
});