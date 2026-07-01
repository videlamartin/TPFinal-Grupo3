<?php
class UsuarioPreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrarVista($usuarioId, $preguntaId)
    {
        // INSERT IGNORE para no romper si ya existe
        $sql = "INSERT IGNORE INTO usuario_pregunta (usuario_id, pregunta_id)
                VALUES (?, ?)";
        $this->database->execute($sql, [$usuarioId, $preguntaId]);
    }

    public function obtenerIdsVistas($usuarioId)
    {
        $sql = "SELECT pregunta_id FROM usuario_pregunta WHERE usuario_id = ?";
        $resultado = $this->database->query($sql, [$usuarioId]);
        return array_column($resultado, 'pregunta_id');
    }

    public function resetearSiSinPreguntas($usuarioId, $totalPreguntas)
    {
        $sql = "SELECT COUNT(*) as vistas FROM usuario_pregunta WHERE usuario_id = ?";
        $resultado = $this->database->query($sql, [$usuarioId]);
        $vistas = (int) $resultado[0]['vistas'];

        if ($vistas >= $totalPreguntas) {
            $sql = "DELETE FROM usuario_pregunta WHERE usuario_id = ?";
            $this->database->execute($sql, [$usuarioId]);
        }
    }
}