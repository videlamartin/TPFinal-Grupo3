<?php
class PerfilController
{
    private $usuarioModel;

    private $partidaModel;
    private $renderer;
    private $request;

    public function __construct($usuarioModel, $partidaModel, $renderer, $request)
    {
        $this->usuarioModel = $usuarioModel;
        $this->partidaModel = $partidaModel;
        $this->renderer = $renderer;
        $this->request = $request;
    }

    public function ver()
    {
        if (!isset($_SESSION['id_usuario'])) {
            Redirect::to('/login/ver');
        }

        $id = $this->request->get('id');

        // si no mandan id, muestra el logueado
        if (!$id) {
            $id = $_SESSION['id_usuario'];
        }

        $usuario = $this->usuarioModel->buscarPorId($id);

        $historial = $this->partidaModel->obtenerHistorialPorUsuario($id);

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
            'ciudad' => $usuario['ciudad']
        ];

        $this->renderer->render('perfil', $datos);
    }
}