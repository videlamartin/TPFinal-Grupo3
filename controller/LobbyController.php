<?php
    class LobbyController
    {
        private $renderer;
        private $request;

        public function __construct($renderer, $request)
        {
            $this->renderer = $renderer;
            $this->request = $request;
        }

        public function ver()
        {
            // Verifica que el usuario haya iniciado sesión
            if (!isset($_SESSION['id_usuario'])) {
                Redirect::to('/login/ver');
            }

            $datos = [
                'username' => $_SESSION['username'],
                'rol' => $_SESSION['rol'],
                'nombre' => $_SESSION['nombre_completo'],
                'puntaje_total' => $_SESSION['puntaje_total']
            ];

            $this->renderer->render('lobby', $datos);
        }
    }



?>