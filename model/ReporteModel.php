<?php
class ReporteModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    // Guarda un nuevo reporte de una pregunta hecho por un usuario.
    public function crear($preguntaId, $usuarioId, $motivo = null)
    {
        $sql = "INSERT INTO reporte (pregunta_id, usuario_id, motivo) VALUES (?, ?, ?)";
        $this->database->execute($sql, [$preguntaId, $usuarioId, $motivo]);
    }
}
