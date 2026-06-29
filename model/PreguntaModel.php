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
    public function obtenerTodas($busqueda = null)
    {
        $params = [];
        $where  = [];

        if ($busqueda !== null && $busqueda !== '') {
            $where[]  = "p.enunciado LIKE ?";
            $params[] = '%' . $busqueda . '%';
        }

        $sql = "SELECT p.id, p.enunciado, p.estado,
                       c.nombre AS categoria_nombre, c.color AS categoria_color
                FROM pregunta p
                JOIN categoria c ON p.categoria_id = c.id"
            . (!empty($where) ? " WHERE " . implode(' AND ', $where) : "")
            . " ORDER BY c.nombre, p.id";

        return $this->database->query($sql, $params);
    }

    public function obtenerCategorias()
    {
        $sql = "SELECT id, nombre, color FROM categoria ORDER BY nombre";
        return $this->database->query($sql, []);
    }

    public function crear($enunciado, $categoriaId, $creadorId, $respuestas)
    {
        // $respuestas es un array de ['texto' => '...', 'es_correcta' => 0|1]
        $sql = "INSERT INTO pregunta (enunciado, categoria_id, creador_id, estado)
                VALUES (?, ?, ?, 'APROBADA')";
        $this->database->execute($sql, [$enunciado, $categoriaId, $creadorId]);
        $preguntaId = $this->database->lastInsertId();

        foreach ($respuestas as $respuesta) {
            $sql = "INSERT INTO respuesta (pregunta_id, texto, es_correcta)
                    VALUES (?, ?, ?)";
            $this->database->execute($sql, [
                $preguntaId,
                $respuesta['texto'],
                $respuesta['es_correcta']
            ]);
        }

        return $preguntaId;
    }

    public function modificar($id, $enunciado, $categoriaId, $respuestas)
    {
        $sql = "UPDATE pregunta SET enunciado = ?, categoria_id = ? WHERE id = ?";
        $this->database->execute($sql, [$enunciado, $categoriaId, $id]);

        foreach ($respuestas as $respuesta) {
            $sql = "UPDATE respuesta SET texto = ?, es_correcta = ? WHERE id = ?";
            $this->database->execute($sql, [
                $respuesta['texto'],
                $respuesta['es_correcta'],
                $respuesta['id']
            ]);
        }
    }

    public function eliminar($id)
    {
        // Baja lógica: no borramos, cambiamos estado
        $sql = "UPDATE pregunta SET estado = 'RECHAZADA' WHERE id = ?";
        $this->database->execute($sql, [$id]);
    }

    public function sugerir($enunciado, $categoriaId, $creadorId, $respuestas)
    {
        $sql = "INSERT INTO pregunta (enunciado, categoria_id, creador_id, estado)
            VALUES (?, ?, ?, 'PENDIENTE')";
        $this->database->execute($sql, [$enunciado, $categoriaId, $creadorId]);
        $preguntaId = $this->database->lastInsertId();

        foreach ($respuestas as $respuesta) {
            $sql = "INSERT INTO respuesta (pregunta_id, texto, es_correcta)
                VALUES (?, ?, ?)";
            $this->database->execute($sql, [
                $preguntaId,
                $respuesta['texto'],
                $respuesta['es_correcta']
            ]);
        }

        return $preguntaId;
    }

    public function obtenerSugeridas()
    {
        $sql = "SELECT p.id, p.enunciado, p.fecha_creacion,
                   u.username AS sugerida_por
            FROM pregunta p
            LEFT JOIN usuario u ON u.id = p.creador_id
            WHERE p.estado = 'PENDIENTE'
            ORDER BY p.fecha_creacion ASC";
        return $this->database->query($sql);
    }

    public function cambiarEstado($id, $estado)
    {
        $sql = "UPDATE pregunta SET estado = ? WHERE id = ?";
        $this->database->execute($sql, [$estado, $id]);
    }
}
