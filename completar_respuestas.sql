-- ============================================================
--  Completar respuestas: agrega la 4ta opción (incorrecta) que
--  les falta a las preguntas que tienen solo 3 respuestas.
--
--  - Busca cada pregunta por su ENUNCIADO (funciona igual en la
--    base local y en producción, aunque los id sean distintos).
--  - Es seguro correrlo más de una vez: no duplica respuestas
--    (el NOT EXISTS evita insertar si ya existe esa opción).
--
--  Ejecutar en phpMyAdmin (o consola MySQL) sobre 'preguntados'.
-- ============================================================

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, '1918', 0 FROM pregunta p
WHERE p.enunciado = '¿En qué año comenzó la Primera Guerra Mundial?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = '1918');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Bartolomé Mitre', 0 FROM pregunta p
WHERE p.enunciado = '¿Quién fue el primer presidente de Argentina?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Bartolomé Mitre');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, '10', 0 FROM pregunta p
WHERE p.enunciado = '¿Cuántos jugadores tiene un equipo de fútbol en cancha?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = '10');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Alemania', 0 FROM pregunta p
WHERE p.enunciado = '¿Qué país ganó el Mundial de Fútbol 2022?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Alemania');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Júpiter', 0 FROM pregunta p
WHERE p.enunciado = '¿Cuál es el planeta más cercano al Sol?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Júpiter');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Nitrógeno', 0 FROM pregunta p
WHERE p.enunciado = '¿Qué gas necesitan las plantas para realizar la fotosíntesis?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Nitrógeno');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Miguel Ángel', 0 FROM pregunta p
WHERE p.enunciado = '¿Quién pintó la Mona Lisa?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Miguel Ángel');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Inglaterra', 0 FROM pregunta p
WHERE p.enunciado = '¿En qué país se encuentra el Museo del Louvre?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Inglaterra');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Draco Malfoy', 0 FROM pregunta p
WHERE p.enunciado = '¿Cuál es el nombre del mago protagonista de Harry Potter?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Draco Malfoy');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Sega', 0 FROM pregunta p
WHERE p.enunciado = '¿Qué compañía creó la consola PlayStation?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Sega');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Misisipi', 0 FROM pregunta p
WHERE p.enunciado = '¿Cuál es el río más largo del mundo según la mayoría de las mediciones?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Misisipi');

INSERT INTO respuesta (pregunta_id, texto, es_correcta)
SELECT p.id, 'Estados Unidos', 0 FROM pregunta p
WHERE p.enunciado = '¿Cuál es el país más grande del mundo?'
  AND NOT EXISTS (SELECT 1 FROM respuesta r WHERE r.pregunta_id = p.id AND r.texto = 'Estados Unidos');
