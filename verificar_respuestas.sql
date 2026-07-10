-- ============================================================
--  Verificación de integridad de las preguntas
--  Objetivo: que TODA pregunta tenga exactamente 4 respuestas
--            y exactamente 1 respuesta correcta.
--
--  Cómo usarlo: pegarlo/ejecutarlo en phpMyAdmin (o en la
--  consola de MySQL) sobre la base 'preguntados', ya sea la
--  local o la de producción.
--
--  Es SOLO de lectura: no modifica ningún dato.
-- ============================================================

-- 1) Preguntas que NO tienen exactamente 4 respuestas.
--    (Si no devuelve filas, todas cumplen.)
SELECT p.id,
       p.enunciado,
       COUNT(r.id) AS cantidad_respuestas
FROM pregunta p
LEFT JOIN respuesta r ON r.pregunta_id = p.id
GROUP BY p.id, p.enunciado
HAVING COUNT(r.id) <> 4
ORDER BY cantidad_respuestas, p.id;


-- 2) Preguntas que NO tienen exactamente 1 respuesta correcta.
--    (Una pregunta válida debe tener una sola respuesta correcta.)
SELECT p.id,
       p.enunciado,
       SUM(r.es_correcta) AS respuestas_correctas
FROM pregunta p
LEFT JOIN respuesta r ON r.pregunta_id = p.id
GROUP BY p.id, p.enunciado
HAVING SUM(r.es_correcta) <> 1
ORDER BY p.id;


-- 3) Resumen general: cuántas preguntas hay por cantidad de respuestas.
--    Lo ideal es ver una sola fila: 4 respuestas -> N preguntas.
SELECT cantidad_respuestas,
       COUNT(*) AS cantidad_de_preguntas
FROM (
    SELECT p.id, COUNT(r.id) AS cantidad_respuestas
    FROM pregunta p
    LEFT JOIN respuesta r ON r.pregunta_id = p.id
    GROUP BY p.id
) t
GROUP BY cantidad_respuestas
ORDER BY cantidad_respuestas;
