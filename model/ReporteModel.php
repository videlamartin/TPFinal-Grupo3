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

    public function obtenerReportes()
    {
        $sql = "
        SELECT
            r.id AS reporte_id,
            r.motivo,
            r.fecha_reporte,
            p.id AS pregunta_id,
            p.enunciado,
            u.username
        FROM reporte r
        JOIN pregunta p
            ON p.id = r.pregunta_id
        JOIN usuario u
            ON u.id = r.usuario_id
        ORDER BY r.fecha_reporte DESC
    ";

        return $this->database->query($sql);
    }

    public function mantenerReporte($reporteId)
    {
        $sql = "DELETE FROM reporte WHERE id = ?";
        $this->database->execute($sql, [$reporteId]);

        Redirect::to('/editor/reportadas');
    }

    public function eliminarPorPregunta($preguntaId)
    {
        $sql = "DELETE FROM reporte WHERE pregunta_id = ?";
        $this->database->execute($sql, [$preguntaId]);
    }
}
