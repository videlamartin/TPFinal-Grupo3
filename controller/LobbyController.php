<?php

class LobbyController
{
    private $renderer;
    private $request;
    private $partidaModel;

    public function __construct($partidaModel,$renderer, $request)
    {
        $this->partidaModel = $partidaModel;
        $this->renderer = $renderer;
        $this->request = $request;
    }

    public function ver()
    {
        if (!isset($_SESSION['id_usuario'])) {
            Redirect::to('/login/ver');
        }
        $historial = $this->partidaModel->obtenerHistorialPorUsuario($_SESSION['id_usuario']);

        $datos = [
            'username' => $_SESSION['username'],
            'rol' => $_SESSION['rol'],
            'nombre' => $_SESSION['nombre_completo'],
            'puntaje_total' => $_SESSION['puntaje_total'],
            'bienvenida_neutro'    => $_SESSION['sexo'] === 'Prefiero no cargarlo',
            'bienvenido'    => $_SESSION['sexo'] === 'Femenino',
            'bienvenida'    => $_SESSION['sexo'] === 'Femenino',
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