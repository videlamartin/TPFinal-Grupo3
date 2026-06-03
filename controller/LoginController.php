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
            header('Location: /login');
            exit();
        }

        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $usuario = $this->usuarioModel->buscarPorUsername($username);

        if (!$usuario) {

            $_SESSION['error'] = 'Usuario inexistente';

            header('Location: /login/ver');
            exit();
        }

        if (!$usuario['activo']) {

            $_SESSION['error'] = 'La cuenta no fue validada';

            header('Location: /login/ver');
            exit();
        }

        if ($password !== $usuario['password']) {

            $_SESSION['error'] = 'Contraseña incorrecta';

            header('Location: /login/ver');
            exit();
        }

        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['username'] = $usuario['username'];
        $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
        $_SESSION['puntaje_total'] = $usuario['puntaje_total'];
        $_SESSION['rol'] = $usuario['rol'];

        header('Location: /lobby/ver');
        exit();
    }

        public function logout()
        {
            session_destroy();

            header('Location: /login');
            exit();
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