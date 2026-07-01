<?php
class PartidaModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }

    public function crearPartida($usuarioId)
    {
        $sql = "INSERT INTO partida (usuario_id) VALUES (?)";
        $this->database->execute($sql, [$usuarioId]);
        return $this->database->lastInsertId(); //guardar el partida_id en la sesion despues de crear la partida
    }

    public function sumarPunto($partidaId)
    {
        $sql = "UPDATE partida SET puntaje = puntaje + 1 WHERE id = ?";
        $this->database->execute($sql, [$partidaId]);
    }

    public function finalizar($partidaId)
    {
        $sql = "UPDATE partida SET estado = 'FINALIZADA', fecha_fin = NOW() WHERE id = ?";
        $this->database->execute($sql, [$partidaId]);
    }


    public function obtenerPorId($partidaId)
    {
        $sql = "SELECT * FROM partida WHERE id = ?";
        $resultado = $this->database->query($sql, [$partidaId]);

        return count($resultado) > 0 ? $resultado[0] : null;
    }
    public function obtenerHistorialPorUsuario($usuarioId, $limite = 5)
    {
        $sql = "SELECT fecha_inicio, puntaje 
            FROM partida 
            WHERE usuario_id = ? AND estado = 'FINALIZADA'
            ORDER BY fecha_inicio DESC
            LIMIT ?";
        return $this->database->query($sql, [$usuarioId, $limite]);
    }


    public function obtenerGraficoPartidas($periodo)
    {
        switch ($periodo) {

            case 'dia':
                $sql = "
                SELECT DATE(fecha_inicio) AS periodo,
                       COUNT(*) AS total
                FROM partida
                GROUP BY DATE(fecha_inicio)
                ORDER BY DATE(fecha_inicio)
            ";
                break;

            case 'semana':
                $sql = "
                SELECT CONCAT(YEAR(fecha_inicio), '-Semana-', LPAD(WEEK(fecha_inicio,1),2,'0')) AS periodo,
                       COUNT(*) AS total
                FROM partida
                GROUP BY YEAR(fecha_inicio), WEEK(fecha_inicio,1)
                ORDER BY YEAR(fecha_inicio), WEEK(fecha_inicio,1)
            ";
                break;

            case 'mes':
                $sql = "
                SELECT DATE_FORMAT(fecha_inicio, '%Y-%m') AS periodo,
                       COUNT(*) AS total
                FROM partida
                GROUP BY DATE_FORMAT(fecha_inicio, '%Y-%m')
                ORDER BY DATE_FORMAT(fecha_inicio, '%Y-%m')
            ";
                break;

            case 'anio':
                $sql = "
                SELECT YEAR(fecha_inicio) AS periodo,
                       COUNT(*) AS total
                FROM partida
                GROUP BY YEAR(fecha_inicio)
                ORDER BY YEAR(fecha_inicio)
            ";
                break;
        }

        return $this->database->query($sql);
    }

}
