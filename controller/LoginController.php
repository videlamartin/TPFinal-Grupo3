<?php

    class  LoginController
    {
        private $usuarioModel;

        private $renderer;

        private $request;


    public function __construct($usuarioModel, $renderer, $request)
    {

        $this->usuarioModel = $usuarioModel;
        $this->renderer = $renderer;
        $this->request = $request;

    }


        public function ver()
        {
            $datos = [];

            if (isset($_SESSION['error'])) {
                $datos['error'] = $_SESSION['error'];
                unset($_SESSION['error']); // elimina el mensaje
            }

            $this->renderer->render("login", $datos);
        }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('/login/ver');
        }

        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $usuario = $this->usuarioModel->buscarPorUsername($username);

        if (!$usuario) {

            $_SESSION['error'] = 'Usuario inexistente';

            Redirect::to('/login/ver');
        }

        if (!$usuario['activo']) {

            $_SESSION['error'] = 'La cuenta no fue validada';

            Redirect::to('/login/ver');
        }

        if (!password_verify($password, $usuario['password'])) {

            $_SESSION['error'] = 'Contraseña incorrecta';

            Redirect::to('/login/ver');
        }

        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['username'] = $usuario['username'];
        $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
        $_SESSION['puntaje_total'] = $usuario['puntaje_total'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['sexo'] = $usuario['sexo'];

        Redirect::to('/lobby/ver');
    }

        public function logout()
        {
            session_destroy();

            Redirect::to('/login/ver');
        }


        public function validarCuenta()
        {
            $token = $_GET['token'] ?? '';

            $usuario = $this->usuarioModel->buscarPorToken($token);

            if (!$usuario) {
                echo "Token inválido";
                return;
            }

            $this->usuarioModel->activarCuenta($usuario['id']);

            echo "Cuenta validada correctamente";
        }
    }

    ?>