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
            return $this->database->query($sql, [$token])->fetch_assoc();
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

    }

?>
