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

    public function buscarPorId($id)
    {
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

    public function calcularNivelUsuario($usuario)
    {
        if ($usuario['total_preguntas_respondidas'] == 0) return 1;

        $tasa = $usuario['total_respuestas_correctas'] / $usuario['total_preguntas_respondidas'];

        if ($tasa >= 0.60) return 3;
        if ($tasa >= 0.30) return 2;
        return 1;
    }

    public function obtenerRanking()
    {
        $sql = "SELECT id, username, puntaje_total,
                   @posicion := @posicion + 1 AS posicion
            FROM usuario, (SELECT @posicion := 0) AS init
            WHERE activo = 1
            ORDER BY puntaje_total DESC";

        return $this->database->query($sql);
    }

    // Se llama al finalizar una partida: suma el puntaje obtenido al
    // puntaje_total del perfil, y acumula cuantas preguntas respondio
    // en total y cuantas acerto (esto alimenta calcularNivelUsuario).
    public function sumarPuntaje($usuarioId, $puntosGanados, $preguntasRespondidas, $respuestasCorrectas)
    {
        $sql = "
            UPDATE usuario
            SET puntaje_total = puntaje_total + ?,
                total_preguntas_respondidas = total_preguntas_respondidas + ?,
                total_respuestas_correctas = total_respuestas_correctas + ?
            WHERE id = ?
        ";
        $this->database->execute($sql, [
            $puntosGanados,
            $preguntasRespondidas,
            $respuestasCorrectas,
            $usuarioId
        ]);
    }


    public function obtenerCantidadUsuarios($periodo = null)
    {
        $sql = "
        SELECT COUNT(*) AS total 
        FROM usuario
        WHERE activo = 1";
        $resultado = $this->database->query($sql);

        return $resultado[0]['total'] ?? 0;
    }


    public function obtenerEvolucionUsuarios($periodo)
    {
        switch ($periodo) {

            case 'dia':
                $sql = "
                SELECT DATE(fecha_creacion) AS periodo,
                       COUNT(*) AS total
                FROM usuario
                GROUP BY DATE(fecha_creacion)
                ORDER BY DATE(fecha_creacion)
            ";
                break;

            case 'semana':
                $sql = "
                SELECT CONCAT(YEAR(fecha_creacion), '-Semana-', LPAD(WEEK(fecha_creacion,1),2,'0')) AS periodo,
                       COUNT(*) AS total
                FROM usuario
                GROUP BY YEAR(fecha_creacion), WEEK(fecha_creacion,1)
                ORDER BY YEAR(fecha_creacion), WEEK(fecha_creacion,1)
            ";
                break;

            case 'mes':
                $sql = "
                SELECT DATE_FORMAT(fecha_creacion, '%Y-%m') AS periodo,
                       COUNT(*) AS total
                FROM usuario
                GROUP BY DATE_FORMAT(fecha_creacion, '%Y-%m')
                ORDER BY DATE_FORMAT(fecha_creacion, '%Y-%m')
            ";
                break;

            case 'anio':
                $sql = "
                SELECT YEAR(fecha_creacion) AS periodo,
                       COUNT(*) AS total
                FROM usuario
                GROUP BY YEAR(fecha_creacion)
                ORDER BY YEAR(fecha_creacion)
            ";
                break;
        }

        return $this->database->query($sql);
    }



}


?>