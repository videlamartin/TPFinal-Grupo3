<?php
class PerfilController {
    private $usuarioModel;
    private $renderer;
    private $request;

    public function __construct($usuarioModel, $renderer, $request) {
        $this->usuarioModel = $usuarioModel;
        $this->renderer = $renderer;
        $this->request = $request;
    }

    public function ver() {
        if (!isset($_SESSION['id_usuario'])) {
            Redirect::to('/login/ver');
        }
        $usuario = $this->usuarioModel->buscarPorId($_SESSION['id_usuario']);
        $datos = [
            'nombre_completo' => $usuario['nombre_completo'],
            'username'        => $usuario['username'],
            'email'           => $usuario['email'],
            'pais'            => $usuario['pais'],
            'ciudad'          => $usuario['ciudad'],
            'puntaje_total'   => $usuario['puntaje_total'],
            'rol'             => $usuario['rol'],
            'foto_perfil'     => $usuario['foto_perfil'],
        ];
        $this->renderer->render('perfil', $datos);
    }
}