<?php
class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function calcularNivelDePregunta($pregunta)
    {
        if ($pregunta['veces_mostrada'] == 0) return 1;

        $tasa = $pregunta['veces_correcta'] / $pregunta['veces_mostrada'];

        if ($tasa >= 0.60) return 1;
        if ($tasa >= 0.30) return 2;
        return 3;
    }

    public function obtenerPreguntaParaUsuario($nivelUsuario, $preguntasVistas = []) // nivel del usuario + preguntas no vistas = pregunta adecuada.
                                                                                     // en caso de no haber preguntas al nivel del usuario, da aleatorias
    {
        if (!empty($preguntasVistas)) {
            $placeholders = implode(',', array_fill(0, count($preguntasVistas), '?'));
            $sql = "SELECT p.*, c.color AS categoria_color, c.nombre AS categoria_nombre
                    FROM pregunta p
                    JOIN categoria c ON p.categoria_id = c.id
                    WHERE p.estado = 'APROBADA'
                    AND p.id NOT IN ($placeholders)";
            $preguntas = $this->database->query($sql, $preguntasVistas);
        } else {
            $sql = "SELECT p.*, c.color AS categoria_color, c.nombre AS categoria_nombre
                    FROM pregunta p
                    JOIN categoria c ON p.categoria_id = c.id
                    WHERE p.estado = 'APROBADA'";
            $preguntas = $this->database->query($sql, []);
        }

        if (empty($preguntas)) return null;

        // Filtramos por nivel en PHP
        $preguntasDelNivel = array_filter($preguntas, function($p) use ($nivelUsuario) {
            return $this->calcularNivelDePregunta($p) === $nivelUsuario;
        });

        // Si no hay preguntas de ese nivel usamos cualquier aprobada
        $preguntasDisponibles = !empty($preguntasDelNivel) ? $preguntasDelNivel : $preguntas;

        $preguntasDisponibles = array_values($preguntasDisponibles);
        return $preguntasDisponibles[array_rand($preguntasDisponibles)];
    }

    public function obtenerRespuestas($preguntaId)
    {
        $sql = "SELECT * FROM respuesta WHERE pregunta_id = ?";
        return $this->database->query($sql, [$preguntaId]);
    }

    public function registrarMostrada($preguntaId)
    {
        $sql = "UPDATE pregunta SET veces_mostrada = veces_mostrada + 1 WHERE id = ?";
        $this->database->execute($sql, [$preguntaId]);
    }

    public function registrarCorrecta($preguntaId)
    {
        $sql = "UPDATE pregunta SET veces_correcta = veces_correcta + 1 WHERE id = ?";
        $this->database->execute($sql, [$preguntaId]);
    }
}
