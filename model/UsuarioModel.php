<?php

    class UsuarioModel
    {

        private $database;
        public function __construct($database)
        {
            $this->database = $database;
        }

        public function buscarPorUsername($username)
        {
            $sql = "SELECT * FROM usuario WHERE username = ?";

            $resultado = $this->database->query($sql, [$username]);

            return count($resultado) > 0
                ? $resultado[0]
                : null;
        }

        public function buscarPorToken($token)
        {
            $sql = "SELECT * FROM usuario WHERE token_validacion = ?";
            $resultado = $this->database->query($sql, [$token]);
            return count($resultado) > 0 ? $resultado[0] : null;
        }

        public function activarCuenta($idUsuario)
        {
            $sql = "
        UPDATE usuario
        SET activo = 1,
            token_validacion = NULL
        WHERE id = ?
    ";
            $this->database->execute($sql, [$idUsuario]);
        }
        public function buscarPorId($id) {
            $sql = "SELECT * FROM usuario WHERE id = ?";
            $resultado = $this->database->query($sql, [$id]);
            return count($resultado) > 0 ? $resultado[0] : null;
        }

        public function registrar($datos)
{
    // Verificar si el username o email ya existen
    $sqlCheck = "SELECT id FROM usuario WHERE username = ? OR email = ?";
    $existe = $this->database->query($sqlCheck, [$datos['username'], $datos['email']]);
    if (count($existe) > 0) {
        return ['error' => 'El usuario o email ya existe'];
    }

    $token = bin2hex(random_bytes(32));
    $passwordHash = password_hash($datos['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuario 
                (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, password, username, foto_perfil, token_validacion)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $this->database->execute($sql, [
        $datos['nombre_completo'],
        $datos['anio_nacimiento'],
        $datos['sexo'],
        $datos['pais'],
        $datos['ciudad'],
        $datos['email'],
        $passwordHash,
        $datos['username'],
        $datos['foto_perfil'] ?? null,
        $token
    ]);

    return ['token' => $token, 'email' => $datos['email']];
}

public function buscarPorEmail($email)
{
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $resultado = $this->database->query($sql, [$email]);
    return count($resultado) > 0 ? $resultado[0] : null;
}

    }

    

?>
