<?php

class RegistroController
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
            unset($_SESSION['error']);
        }

        $this->renderer->render("registro/registro", $datos);
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /registro/ver');
            exit();
        }

        // Validaciones server-side
        $errores = $this->validar($_POST);
        if (!empty($errores)) {
            $_SESSION['error'] = implode(', ', $errores);
            header('Location: /registro/ver');
            exit();
        }

        // Manejo de foto de perfil
        $fotoPerfil = null;
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $fotoPerfil = $this->subirFoto($_FILES['foto_perfil']);
        }

        $datos = [
            'nombre_completo' => trim($_POST['nombre_completo']),
            'anio_nacimiento' => (int) $_POST['anio_nacimiento'],
            'sexo'            => $_POST['sexo'],
            'pais'            => trim($_POST['pais']),
            'ciudad'          => trim($_POST['ciudad']),
            'email'           => trim($_POST['email']),
            'password'        => $_POST['password'],
            'username'        => trim($_POST['username']),
            'foto_perfil'     => $fotoPerfil
        ];

        $resultado = $this->usuarioModel->registrar($datos);

        if (isset($resultado['error'])) {
            $_SESSION['error'] = $resultado['error'];
            header('Location: /registro/ver');
            exit();
        }

        // Enviar mail de validación
        $this->enviarMailValidacion($resultado['email'], $resultado['token']);

        header('Location: /registro/confirmacion');
        exit();
    }

    public function confirmacion()
    {
        $this->renderer->render("registro/confirmacion", []);
    }

    // --- Métodos privados ---

    private function validar($post)
    {
        $errores = [];

        if (empty($post['nombre_completo']))
            $errores[] = 'El nombre completo es obligatorio';

        if (empty($post['anio_nacimiento']) || !is_numeric($post['anio_nacimiento']))
            $errores[] = 'El año de nacimiento es inválido';

        if (empty($post['sexo']) || !in_array($post['sexo'], ['Masculino', 'Femenino', 'Prefiero no cargarlo']))
            $errores[] = 'El sexo es inválido';

        if (empty($post['pais']))
            $errores[] = 'El país es obligatorio';

        if (empty($post['ciudad']))
            $errores[] = 'La ciudad es obligatoria';

        if (empty($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL))
            $errores[] = 'El email es inválido';

        if (empty($post['password']) || strlen($post['password']) < 6)
            $errores[] = 'La contraseña debe tener al menos 6 caracteres';

        if ($post['password'] !== $post['repetir_password'])
            $errores[] = 'Las contraseñas no coinciden';

        if (empty($post['username']))
            $errores[] = 'El nombre de usuario es obligatorio';

        return $errores;
    }

    private function subirFoto($archivo)
    {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $extensionesPermitidas)) {
            return null;
        }

        $nombreArchivo = uniqid('foto_') . '.' . $extension;
        $destino = __DIR__ . '/../public/uploads/' . $nombreArchivo;
        move_uploaded_file($archivo['tmp_name'], $destino);

        return '/public/uploads/' . $nombreArchivo;
    }

    private function enviarMailValidacion($email, $token)
    {
        $enlace = "http://localhost/?controller=registro&method=validarCuenta&token=" . $token;
        $asunto = "Validá tu cuenta";
        $mensaje = "Hacé click en el siguiente enlace para activar tu cuenta: $enlace";
        $headers = "From: noreply@preguntados.com";

        mail($email, $asunto, $mensaje, $headers);
    }
}