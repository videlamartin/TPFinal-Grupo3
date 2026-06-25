<?php
class PerfilController
{
    private $usuarioModel;

    private $partidaModel;
    private $renderer;
    private $request;

    private $usuarioSesion;

    public function __construct($usuarioModel, $partidaModel, $renderer, $request, $usuarioSesion)
    {
        $this->usuarioModel = $usuarioModel;
        $this->partidaModel = $partidaModel;
        $this->renderer = $renderer;
        $this->request = $request;
        $this->usuarioSesion = $usuarioSesion;
    }

    public function ver()
    {
        if (!$this->usuarioSesion['id']) {
            Redirect::to('/login/ver');
        }

        $id = $this->request->get('id');

        // si no mandan id, muestra el logueado
        if (!$id) {
            $id = $this->usuarioSesion['id'];
        }

        $usuario = $this->usuarioModel->buscarPorId($id);

        $historial = $this->partidaModel->obtenerHistorialPorUsuario($id);

        $urlPerfil = "https://tpquizmaster.free.nf/perfil/ver?id=" . $id;

        $datos = [
            'nombre_completo' => $usuario['nombre_completo'],
            'username' => $usuario['username'],
            'email' => $usuario['email'],
            'pais' => $usuario['pais'],
            'ciudad' => $usuario['ciudad'],
            'puntaje_total' => $usuario['puntaje_total'],
            'rol' => $usuario['rol'],
            'foto_perfil' => $usuario['foto_perfil'],
            'historial'      => $historial,
            'pais' => $usuario['pais'],
            'ciudad' => $usuario['ciudad'],
            'url_perfil' => $urlPerfil,
            'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($urlPerfil)
        ];

        $this->renderer->render('perfil', $datos);
    }
}