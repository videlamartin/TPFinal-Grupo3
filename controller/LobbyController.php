<?php

class LobbyController
{
    private $renderer;
    private $request;
    private $partidaModel;

    private $usuarioSession;

    public function __construct($partidaModel,$renderer, $request, $usuarioSession)
    {
        $this->partidaModel = $partidaModel;
        $this->renderer = $renderer;
        $this->request = $request;
        $this->usuarioSession = $usuarioSession;
    }

    public function ver()
    {
        $rol = $this->usuarioSession['rol'];
        $idUsuario = $this->usuarioSession['id'];

        $historial = $this->partidaModel->obtenerHistorialPorUsuario($_SESSION['id_usuario']);

        $datos = [
            'username' => $this->usuarioSession['username'],
            'rol' => $rol,
            'nombre' => $_SESSION['nombre_completo'],
            'puntaje_total' => $_SESSION['puntaje_total'],
            'bienvenida_neutro'    => $_SESSION['sexo'] === 'Prefiero no cargarlo',
            'bienvenido'    => $_SESSION['sexo'] === 'Femenino',
            'bienvenida'    => $_SESSION['sexo'] === 'Femenino',
            'es_editor' => in_array($_SESSION['rol'], ['editor', 'administrador']),
            'historial' => $historial,
];

        $this->renderer->render('lobby', $datos);
    }

    public function cerrarSesion()
    {
        session_destroy();
        Redirect::to('/login/ver');
    }

}
?>