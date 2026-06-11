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
}
