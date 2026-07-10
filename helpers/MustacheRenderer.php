<?php

class MustacheRenderer {
    private $mustache;

    public function __construct($viewsFolder) {
        $this->mustache = new Mustache\Engine([
            'loader'          => new Mustache\Loader\FilesystemLoader($viewsFolder),
            'partials_loader' => new Mustache\Loader\FilesystemLoader($viewsFolder),
        ]);
    }

    public function render($viewName, $data = []) {
        // Inyecta los datos de la barra de navegación (nav_*) desde la sesión,
        // así el navbar funciona en todas las vistas sin tocar los controladores.
        // Los datos propios de cada vista tienen prioridad (van segundos en el merge).
        $data = array_merge($this->navContext(), $data);

        $template = $this->mustache->loadTemplate($viewName);
        echo $template->render($data);
    }

    private function navContext() {
        if (empty($_SESSION['id_usuario'])) {
            return ['nav_activa' => false];
        }

        $rol      = $_SESSION['rol'] ?? '';
        $username = $_SESSION['username'] ?? '';

        return [
            'nav_activa'     => true,
            'nav_username'   => $username,
            'nav_nombre'     => $_SESSION['nombre_completo'] ?? $username,
            'nav_inicial'    => mb_strtoupper(mb_substr($username, 0, 1)),
            'nav_puntaje'    => $_SESSION['puntaje_total'] ?? 0,
            'nav_es_editor'  => $rol === 'editor',
            'nav_es_admin'   => $rol === 'administrador',
            'nav_es_jugador' => $rol === 'jugador',
        ];
    }
}
 