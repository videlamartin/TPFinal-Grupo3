<?php
class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerPreguntaParaUsuario($nivelUsuario, $preguntasVistas = [], $categoriaId = null)
    {
        $params = [];
        $where = ["p.estado = 'APROBADA'"];

        if ($categoriaId !== null) {
            $where[] = "p.categoria_id = ?";
            $params[] = $categoriaId;
        }

        if (!empty($preguntasVistas)) {
            $placeholders = implode(',', array_fill(0, count($preguntasVistas), '?'));
            $where[] = "p.id NOT IN ($placeholders)";
            $params = array_merge($params, $preguntasVistas);
        }

        $sql = "SELECT p.*, c.color AS categoria_color, c.nombre AS categoria_nombre
            FROM pregunta p
            JOIN categoria c ON p.categoria_id = c.id
            WHERE " . implode(' AND ', $where);

        $preguntas = $this->database->query($sql, $params);

        if (empty($preguntas)) return null;

        $preguntasDelNivel = array_filter($preguntas, function($p) use ($nivelUsuario) {
            return $this->calcularNivelDePregunta($p) === $nivelUsuario;
        });

        $preguntasDisponibles = !empty($preguntasDelNivel) ? $preguntasDelNivel : $preguntas;
        $preguntasDisponibles = array_values($preguntasDisponibles);
        return $preguntasDisponibles[array_rand($preguntasDisponibles)];
    }

    public function calcularNivelDePregunta($pregunta)
    {
        $MIN_MUESTRAS = 10;

        if ($pregunta['veces_mostrada'] < $MIN_MUESTRAS) {
            return 1;
        }

        $tasa = $pregunta['veces_correcta'] / $pregunta['veces_mostrada'];

        if ($tasa >= 0.60) return 1;
        if ($tasa >= 0.30) return 2;
        return 3;
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
    public function verificarRespuesta($respuestaId)
    {
        $sql = "SELECT * FROM respuesta WHERE id = ?";
        $resultado = $this->database->query($sql, [$respuestaId]);
        return count($resultado) > 0 ? $resultado[0] : null;
    }
    public function obtenerRespuestaCorrecta($preguntaId)
    {
        $sql = "SELECT * FROM respuesta WHERE pregunta_id = ? AND es_correcta = 1";
        $resultado = $this->database->query($sql, [$preguntaId]);
        return count($resultado) > 0 ? $resultado[0] : null;
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT 
                p.id,
                p.enunciado,
                p.categoria_id,
                c.nombre AS categoria_nombre,
                c.color AS categoria_color
            FROM pregunta p
            INNER JOIN categoria c ON p.categoria_id = c.id
            WHERE p.id = ?";

        $result = $this->database->query($sql, [$id]);

        return $result[0] ?? null;
    }
}
