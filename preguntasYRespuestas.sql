-- ============================================================
--  SEED: 10 preguntas por categoría (60 preguntas en total)
--  Ajustá creador_id=1 si tu admin tiene otro ID
-- ============================================================

SET FOREIGN_KEY_CHECKS=0;

-- ============================================================
-- HISTORIA (categoria_id = 1)
-- ============================================================
INSERT INTO `pregunta` (`enunciado`, `categoria_id`, `creador_id`, `estado`) VALUES
                                                                                 ('¿En qué año comenzó la Primera Guerra Mundial?', 1, 1, 'APROBADA'),
                                                                                 ('¿Quién fue el primer presidente de los Estados Unidos?', 1, 1, 'APROBADA'),
                                                                                 ('¿En qué año cayó el Muro de Berlín?', 1, 1, 'APROBADA'),
                                                                                 ('¿Qué civilización construyó las pirámides de Guiza?', 1, 1, 'APROBADA'),
                                                                                 ('¿En qué año llegó Colón a América?', 1, 1, 'APROBADA'),
                                                                                 ('¿Qué imperio fue conocido como "el imperio donde nunca se pone el sol"?', 1, 1, 'APROBADA'),
                                                                                 ('¿En qué país se desarrolló la Revolución Francesa?', 1, 1, 'APROBADA'),
                                                                                 ('¿Quién fue el líder de la Revolución Rusa de 1917?', 1, 1, 'APROBADA'),
                                                                                 ('¿En qué año terminó la Segunda Guerra Mundial?', 1, 1, 'APROBADA'),
                                                                                 ('¿Qué ciudad fue destruida por la erupción del Vesubio en el año 79 d.C.?', 1, 1, 'APROBADA');

SET @h1 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué año comenzó la Primera Guerra Mundial?' LIMIT 1);
SET @h2 = (SELECT id FROM pregunta WHERE enunciado = '¿Quién fue el primer presidente de los Estados Unidos?' LIMIT 1);
SET @h3 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué año cayó el Muro de Berlín?' LIMIT 1);
SET @h4 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué civilización construyó las pirámides de Guiza?' LIMIT 1);
SET @h5 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué año llegó Colón a América?' LIMIT 1);
SET @h6 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué imperio fue conocido como "el imperio donde nunca se pone el sol"?' LIMIT 1);
SET @h7 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué país se desarrolló la Revolución Francesa?' LIMIT 1);
SET @h8 = (SELECT id FROM pregunta WHERE enunciado = '¿Quién fue el líder de la Revolución Rusa de 1917?' LIMIT 1);
SET @h9 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué año terminó la Segunda Guerra Mundial?' LIMIT 1);
SET @h10 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué ciudad fue destruida por la erupción del Vesubio en el año 79 d.C.?' LIMIT 1);

INSERT INTO `respuesta` (`pregunta_id`, `texto`, `es_correcta`) VALUES
                                                                    (@h1, '1914', 1), (@h1, '1918', 0), (@h1, '1939', 0), (@h1, '1905', 0),
                                                                    (@h2, 'George Washington', 1), (@h2, 'Abraham Lincoln', 0), (@h2, 'Thomas Jefferson', 0), (@h2, 'Benjamin Franklin', 0),
                                                                    (@h3, '1989', 1), (@h3, '1991', 0), (@h3, '1985', 0), (@h3, '1975', 0),
                                                                    (@h4, 'Los egipcios', 1), (@h4, 'Los romanos', 0), (@h4, 'Los griegos', 0), (@h4, 'Los persas', 0),
                                                                    (@h5, '1492', 1), (@h5, '1488', 0), (@h5, '1500', 0), (@h5, '1510', 0),
                                                                    (@h6, 'El Imperio Español', 1), (@h6, 'El Imperio Romano', 0), (@h6, 'El Imperio Británico', 0), (@h6, 'El Imperio Mongol', 0),
                                                                    (@h7, 'Francia', 1), (@h7, 'Inglaterra', 0), (@h7, 'Alemania', 0), (@h7, 'Italia', 0),
                                                                    (@h8, 'Lenin', 1), (@h8, 'Stalin', 0), (@h8, 'Trotsky', 0), (@h8, 'Rasputin', 0),
                                                                    (@h9, '1945', 1), (@h9, '1943', 0), (@h9, '1947', 0), (@h9, '1950', 0),
                                                                    (@h10, 'Pompeya', 1), (@h10, 'Roma', 0), (@h10, 'Nápoles', 0), (@h10, 'Herculano', 0);

-- ============================================================
-- DEPORTES (categoria_id = 2)
-- ============================================================
INSERT INTO `pregunta` (`enunciado`, `categoria_id`, `creador_id`, `estado`) VALUES
                                                                                 ('¿En qué país se realizó el Mundial de fútbol 2022?', 2, 1, 'APROBADA'),
                                                                                 ('¿Cuántos jugadores hay en un equipo de fútbol en cancha?', 2, 1, 'APROBADA'),
                                                                                 ('¿Qué país ganó más Copa del Mundo de fútbol?', 2, 1, 'APROBADA'),
                                                                                 ('¿En qué deporte se usa el término "home run"?', 2, 1, 'APROBADA'),
                                                                                 ('¿Cuántos sets se juegan en un partido de tenis de Grand Slam masculino?', 2, 1, 'APROBADA'),
                                                                                 ('¿Cada cuántos años se celebran los Juegos Olímpicos de verano?', 2, 1, 'APROBADA'),
                                                                                 ('¿Qué equipo argentino ganó más títulos de la Liga argentina?', 2, 1, 'APROBADA'),
                                                                                 ('¿Cuántos puntos vale un try en rugby?', 2, 1, 'APROBADA'),
                                                                                 ('¿En qué deporte compite Novak Djokovic?', 2, 1, 'APROBADA'),
                                                                                 ('¿Cuántos aros tiene la bandera olímpica?', 2, 1, 'APROBADA');

SET @d1 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué país se realizó el Mundial de fútbol 2022?' LIMIT 1);
SET @d2 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántos jugadores hay en un equipo de fútbol en cancha?' LIMIT 1);
SET @d3 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué país ganó más Copa del Mundo de fútbol?' LIMIT 1);
SET @d4 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué deporte se usa el término "home run"?' LIMIT 1);
SET @d5 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántos sets se juegan en un partido de tenis de Grand Slam masculino?' LIMIT 1);
SET @d6 = (SELECT id FROM pregunta WHERE enunciado = '¿Cada cuántos años se celebran los Juegos Olímpicos de verano?' LIMIT 1);
SET @d7 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué equipo argentino ganó más títulos de la Liga argentina?' LIMIT 1);
SET @d8 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántos puntos vale un try en rugby?' LIMIT 1);
SET @d9 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué deporte compite Novak Djokovic?' LIMIT 1);
SET @d10 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántos aros tiene la bandera olímpica?' LIMIT 1);

INSERT INTO `respuesta` (`pregunta_id`, `texto`, `es_correcta`) VALUES
                                                                    (@d1, 'Qatar', 1), (@d1, 'Brasil', 0), (@d1, 'Rusia', 0), (@d1, 'Alemania', 0),
                                                                    (@d2, '11', 1), (@d2, '10', 0), (@d2, '12', 0), (@d2, '9', 0),
                                                                    (@d3, 'Brasil', 1), (@d3, 'Alemania', 0), (@d3, 'Argentina', 0), (@d3, 'Italia', 0),
                                                                    (@d4, 'Béisbol', 1), (@d4, 'Cricket', 0), (@d4, 'Softball', 0), (@d4, 'Golf', 0),
                                                                    (@d5, '5 sets', 1), (@d5, '3 sets', 0), (@d5, '4 sets', 0), (@d5, '7 sets', 0),
                                                                    (@d6, 'Cada 4 años', 1), (@d6, 'Cada 2 años', 0), (@d6, 'Cada 3 años', 0), (@d6, 'Cada 5 años', 0),
                                                                    (@d7, 'River Plate', 1), (@d7, 'Boca Juniors', 0), (@d7, 'Independiente', 0), (@d7, 'Racing Club', 0),
                                                                    (@d8, '5 puntos', 1), (@d8, '3 puntos', 0), (@d8, '7 puntos', 0), (@d8, '4 puntos', 0),
                                                                    (@d9, 'Tenis', 1), (@d9, 'Squash', 0), (@d9, 'Badminton', 0), (@d9, 'Pádel', 0),
                                                                    (@d10, '5', 1), (@d10, '4', 0), (@d10, '6', 0), (@d10, '7', 0);

-- ============================================================
-- CIENCIA (categoria_id = 3)
-- ============================================================
INSERT INTO `pregunta` (`enunciado`, `categoria_id`, `creador_id`, `estado`) VALUES
                                                                                 ('¿Cuál es el símbolo químico del oro?', 3, 1, 'APROBADA'),
                                                                                 ('¿Cuántos huesos tiene el cuerpo humano adulto?', 3, 1, 'APROBADA'),
                                                                                 ('¿Qué planeta es el más grande del sistema solar?', 3, 1, 'APROBADA'),
                                                                                 ('¿A qué velocidad viaja la luz en el vacío (aproximadamente)?', 3, 1, 'APROBADA'),
                                                                                 ('¿Cuál es el elemento más abundante en el universo?', 3, 1, 'APROBADA'),
                                                                                 ('¿Quién propuso la teoría de la evolución por selección natural?', 3, 1, 'APROBADA'),
                                                                                 ('¿Cuántos cromosomas tiene una célula humana normal?', 3, 1, 'APROBADA'),
                                                                                 ('¿Qué gas es el más abundante en la atmósfera terrestre?', 3, 1, 'APROBADA'),
                                                                                 ('¿En qué unidad se mide la frecuencia de una onda?', 3, 1, 'APROBADA'),
                                                                                 ('¿Cuál es el planeta más cercano al Sol?', 3, 1, 'APROBADA');

SET @c1 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es el símbolo químico del oro?' LIMIT 1);
SET @c2 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántos huesos tiene el cuerpo humano adulto?' LIMIT 1);
SET @c3 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué planeta es el más grande del sistema solar?' LIMIT 1);
SET @c4 = (SELECT id FROM pregunta WHERE enunciado = '¿A qué velocidad viaja la luz en el vacío (aproximadamente)?' LIMIT 1);
SET @c5 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es el elemento más abundante en el universo?' LIMIT 1);
SET @c6 = (SELECT id FROM pregunta WHERE enunciado = '¿Quién propuso la teoría de la evolución por selección natural?' LIMIT 1);
SET @c7 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántos cromosomas tiene una célula humana normal?' LIMIT 1);
SET @c8 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué gas es el más abundante en la atmósfera terrestre?' LIMIT 1);
SET @c9 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué unidad se mide la frecuencia de una onda?' LIMIT 1);
SET @c10 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es el planeta más cercano al Sol?' LIMIT 1);

INSERT INTO `respuesta` (`pregunta_id`, `texto`, `es_correcta`) VALUES
                                                                    (@c1, 'Au', 1), (@c1, 'Go', 0), (@c1, 'Ag', 0), (@c1, 'Gd', 0),
                                                                    (@c2, '206', 1), (@c2, '212', 0), (@c2, '198', 0), (@c2, '220', 0),
                                                                    (@c3, 'Júpiter', 1), (@c3, 'Saturno', 0), (@c3, 'Neptuno', 0), (@c3, 'Urano', 0),
                                                                    (@c4, '300.000 km/s', 1), (@c4, '150.000 km/s', 0), (@c4, '500.000 km/s', 0), (@c4, '1.000.000 km/s', 0),
                                                                    (@c5, 'Hidrógeno', 1), (@c5, 'Helio', 0), (@c5, 'Oxígeno', 0), (@c5, 'Carbono', 0),
                                                                    (@c6, 'Charles Darwin', 1), (@c6, 'Gregor Mendel', 0), (@c6, 'Louis Pasteur', 0), (@c6, 'Isaac Newton', 0),
                                                                    (@c7, '46', 1), (@c7, '48', 0), (@c7, '44', 0), (@c7, '23', 0),
                                                                    (@c8, 'Nitrógeno', 1), (@c8, 'Oxígeno', 0), (@c8, 'Dióxido de carbono', 0), (@c8, 'Argón', 0),
                                                                    (@c9, 'Hertz', 1), (@c9, 'Joule', 0), (@c9, 'Pascal', 0), (@c9, 'Newton', 0),
                                                                    (@c10, 'Mercurio', 1), (@c10, 'Venus', 0), (@c10, 'Marte', 0), (@c10, 'La Tierra', 0);

-- ============================================================
-- ARTE (categoria_id = 4)
-- ============================================================
INSERT INTO `pregunta` (`enunciado`, `categoria_id`, `creador_id`, `estado`) VALUES
                                                                                 ('¿Quién pintó la Mona Lisa?', 4, 1, 'APROBADA'),
                                                                                 ('¿En qué ciudad se encuentra el museo del Louvre?', 4, 1, 'APROBADA'),
                                                                                 ('¿Qué artista español es famoso por el cubismo?', 4, 1, 'APROBADA'),
                                                                                 ('¿Quién esculpió "El pensador"?', 4, 1, 'APROBADA'),
                                                                                 ('¿En qué siglo vivió Miguel Ángel?', 4, 1, 'APROBADA'),
                                                                                 ('¿Cuál es la obra más famosa de Vincent van Gogh?', 4, 1, 'APROBADA'),
                                                                                 ('¿Qué movimiento artístico representó Salvador Dalí?', 4, 1, 'APROBADA'),
                                                                                 ('¿Quién compuso la Quinta Sinfonía?', 4, 1, 'APROBADA'),
                                                                                 ('¿En qué país nació el tango como género musical y danza?', 4, 1, 'APROBADA'),
                                                                                 ('¿Qué arquitecto diseñó la Sagrada Familia de Barcelona?', 4, 1, 'APROBADA');

SET @a1 = (SELECT id FROM pregunta WHERE enunciado = '¿Quién pintó la Mona Lisa?' LIMIT 1);
SET @a2 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué ciudad se encuentra el museo del Louvre?' LIMIT 1);
SET @a3 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué artista español es famoso por el cubismo?' LIMIT 1);
SET @a4 = (SELECT id FROM pregunta WHERE enunciado = '¿Quién esculpió "El pensador"?' LIMIT 1);
SET @a5 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué siglo vivió Miguel Ángel?' LIMIT 1);
SET @a6 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es la obra más famosa de Vincent van Gogh?' LIMIT 1);
SET @a7 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué movimiento artístico representó Salvador Dalí?' LIMIT 1);
SET @a8 = (SELECT id FROM pregunta WHERE enunciado = '¿Quién compuso la Quinta Sinfonía?' LIMIT 1);
SET @a9 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué país nació el tango como género musical y danza?' LIMIT 1);
SET @a10 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué arquitecto diseñó la Sagrada Familia de Barcelona?' LIMIT 1);

INSERT INTO `respuesta` (`pregunta_id`, `texto`, `es_correcta`) VALUES
                                                                    (@a1, 'Leonardo da Vinci', 1), (@a1, 'Miguel Ángel', 0), (@a1, 'Rafael', 0), (@a1, 'Botticelli', 0),
                                                                    (@a2, 'París', 1), (@a2, 'Londres', 0), (@a2, 'Roma', 0), (@a2, 'Madrid', 0),
                                                                    (@a3, 'Pablo Picasso', 1), (@a3, 'Salvador Dalí', 0), (@a3, 'Joan Miró', 0), (@a3, 'Francisco Goya', 0),
                                                                    (@a4, 'Auguste Rodin', 1), (@a4, 'Miguel Ángel', 0), (@a4, 'Donatello', 0), (@a4, 'Bernini', 0),
                                                                    (@a5, 'Siglo XV-XVI', 1), (@a5, 'Siglo XIII', 0), (@a5, 'Siglo XVII', 0), (@a5, 'Siglo XIV', 0),
                                                                    (@a6, 'La noche estrellada', 1), (@a6, 'Los girasoles', 0), (@a6, 'El dormitorio', 0), (@a6, 'Autorretrato con oreja vendada', 0),
                                                                    (@a7, 'Surrealismo', 1), (@a7, 'Cubismo', 0), (@a7, 'Expresionismo', 0), (@a7, 'Dadaísmo', 0),
                                                                    (@a8, 'Ludwig van Beethoven', 1), (@a8, 'Wolfgang Amadeus Mozart', 0), (@a8, 'Johann Sebastian Bach', 0), (@a8, 'Franz Schubert', 0),
                                                                    (@a9, 'Argentina', 1), (@a9, 'Uruguay', 0), (@a9, 'Brasil', 0), (@a9, 'Cuba', 0),
                                                                    (@a10, 'Antoni Gaudí', 1), (@a10, 'Santiago Calatrava', 0), (@a10, 'Rafael Moneo', 0), (@a10, 'Ludwig Mies van der Rohe', 0);

-- ============================================================
-- ENTRETENIMIENTO (categoria_id = 5)
-- ============================================================
INSERT INTO `pregunta` (`enunciado`, `categoria_id`, `creador_id`, `estado`) VALUES
                                                                                 ('¿En qué año se estrenó la primera película de Star Wars?', 5, 1, 'APROBADA'),
                                                                                 ('¿Quién interpreta a Iron Man en el Universo Cinematográfico de Marvel?', 5, 1, 'APROBADA'),
                                                                                 ('¿De qué país es originaria la serie "La Casa de Papel"?', 5, 1, 'APROBADA'),
                                                                                 ('¿Cuántas temporadas tiene la serie "Breaking Bad"?', 5, 1, 'APROBADA'),
                                                                                 ('¿Qué personaje dice la frase "Winter is coming"?', 5, 1, 'APROBADA'),
                                                                                 ('¿En qué plataforma se estrenó originalmente la serie "Stranger Things"?', 5, 1, 'APROBADA'),
                                                                                 ('¿Qué banda grabó el álbum "Thriller"?', 5, 1, 'APROBADA'),
                                                                                 ('¿Cuántas películas principales tiene la saga de Harry Potter?', 5, 1, 'APROBADA'),
                                                                                 ('¿Qué juego de mesa tiene piezas llamadas peón, torre, alfil y reina?', 5, 1, 'APROBADA'),
                                                                                 ('¿En qué año se fundó YouTube?', 5, 1, 'APROBADA');

SET @e1 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué año se estrenó la primera película de Star Wars?' LIMIT 1);
SET @e2 = (SELECT id FROM pregunta WHERE enunciado = '¿Quién interpreta a Iron Man en el Universo Cinematográfico de Marvel?' LIMIT 1);
SET @e3 = (SELECT id FROM pregunta WHERE enunciado = '¿De qué país es originaria la serie "La Casa de Papel"?' LIMIT 1);
SET @e4 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántas temporadas tiene la serie "Breaking Bad"?' LIMIT 1);
SET @e5 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué personaje dice la frase "Winter is coming"?' LIMIT 1);
SET @e6 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué plataforma se estrenó originalmente la serie "Stranger Things"?' LIMIT 1);
SET @e7 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué banda grabó el álbum "Thriller"?' LIMIT 1);
SET @e8 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántas películas principales tiene la saga de Harry Potter?' LIMIT 1);
SET @e9 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué juego de mesa tiene piezas llamadas peón, torre, alfil y reina?' LIMIT 1);
SET @e10 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué año se fundó YouTube?' LIMIT 1);

INSERT INTO `respuesta` (`pregunta_id`, `texto`, `es_correcta`) VALUES
                                                                    (@e1, '1977', 1), (@e1, '1975', 0), (@e1, '1980', 0), (@e1, '1983', 0),
                                                                    (@e2, 'Robert Downey Jr.', 1), (@e2, 'Chris Evans', 0), (@e2, 'Mark Ruffalo', 0), (@e2, 'Chris Hemsworth', 0),
                                                                    (@e3, 'España', 1), (@e3, 'México', 0), (@e3, 'Argentina', 0), (@e3, 'Colombia', 0),
                                                                    (@e4, '5', 1), (@e4, '4', 0), (@e4, '6', 0), (@e4, '3', 0),
                                                                    (@e5, 'Ned Stark', 1), (@e5, 'Jon Snow', 0), (@e5, 'Tyrion Lannister', 0), (@e5, 'Daenerys Targaryen', 0),
                                                                    (@e6, 'Netflix', 1), (@e6, 'HBO', 0), (@e6, 'Amazon Prime', 0), (@e6, 'Disney+', 0),
                                                                    (@e7, 'Michael Jackson', 1), (@e7, 'Prince', 0), (@e7, 'Madonna', 0), (@e7, 'Whitney Houston', 0),
                                                                    (@e8, '8', 1), (@e8, '7', 0), (@e8, '9', 0), (@e8, '6', 0),
                                                                    (@e9, 'Ajedrez', 1), (@e9, 'Damas', 0), (@e9, 'Monopoly', 0), (@e9, 'Scrabble', 0),
                                                                    (@e10, '2005', 1), (@e10, '2003', 0), (@e10, '2007', 0), (@e10, '2004', 0);

-- ============================================================
-- GEOGRAFÍA (categoria_id = 6)
-- ============================================================
INSERT INTO `pregunta` (`enunciado`, `categoria_id`, `creador_id`, `estado`) VALUES
                                                                                 ('¿Cuál es el país más grande del mundo por superficie?', 6, 1, 'APROBADA'),
                                                                                 ('¿Cuál es la capital de Australia?', 6, 1, 'APROBADA'),
                                                                                 ('¿En qué continente se encuentra Egipto?', 6, 1, 'APROBADA'),
                                                                                 ('¿Cuál es el río más largo del mundo?', 6, 1, 'APROBADA'),
                                                                                 ('¿Cuántos países forman América del Sur?', 6, 1, 'APROBADA'),
                                                                                 ('¿Cuál es la montaña más alta del mundo?', 6, 1, 'APROBADA'),
                                                                                 ('¿Qué océano es el más grande?', 6, 1, 'APROBADA'),
                                                                                 ('¿Cuál es la capital de Canadá?', 6, 1, 'APROBADA'),
                                                                                 ('¿En qué país se encuentra la Torre Eiffel?', 6, 1, 'APROBADA'),
                                                                                 ('¿Cuál es el desierto más grande del mundo?', 6, 1, 'APROBADA');

SET @g1 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es el país más grande del mundo por superficie?' LIMIT 1);
SET @g2 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es la capital de Australia?' LIMIT 1);
SET @g3 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué continente se encuentra Egipto?' LIMIT 1);
SET @g4 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es el río más largo del mundo?' LIMIT 1);
SET @g5 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuántos países forman América del Sur?' LIMIT 1);
SET @g6 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es la montaña más alta del mundo?' LIMIT 1);
SET @g7 = (SELECT id FROM pregunta WHERE enunciado = '¿Qué océano es el más grande?' LIMIT 1);
SET @g8 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es la capital de Canadá?' LIMIT 1);
SET @g9 = (SELECT id FROM pregunta WHERE enunciado = '¿En qué país se encuentra la Torre Eiffel?' LIMIT 1);
SET @g10 = (SELECT id FROM pregunta WHERE enunciado = '¿Cuál es el desierto más grande del mundo?' LIMIT 1);

INSERT INTO `respuesta` (`pregunta_id`, `texto`, `es_correcta`) VALUES
                                                                    (@g1, 'Rusia', 1), (@g1, 'Canadá', 0), (@g1, 'China', 0), (@g1, 'Estados Unidos', 0),
                                                                    (@g2, 'Canberra', 1), (@g2, 'Sídney', 0), (@g2, 'Melbourne', 0), (@g2, 'Brisbane', 0),
                                                                    (@g3, 'África', 1), (@g3, 'Asia', 0), (@g3, 'Medio Oriente', 0), (@g3, 'Europa', 0),
                                                                    (@g4, 'El Nilo', 1), (@g4, 'El Amazonas', 0), (@g4, 'El Yangtsé', 0), (@g4, 'El Mississippi', 0),
                                                                    (@g5, '12', 1), (@g5, '10', 0), (@g5, '14', 0), (@g5, '13', 0),
                                                                    (@g6, 'Monte Everest', 1), (@g6, 'K2', 0), (@g6, 'Monte Aconcagua', 0), (@g6, 'Monte Kilimanjaro', 0),
                                                                    (@g7, 'Océano Pacífico', 1), (@g7, 'Océano Atlántico', 0), (@g7, 'Océano Índico', 0), (@g7, 'Océano Ártico', 0),
                                                                    (@g8, 'Ottawa', 1), (@g8, 'Toronto', 0), (@g8, 'Vancouver', 0), (@g8, 'Montreal', 0),
                                                                    (@g9, 'Francia', 1), (@g9, 'Bélgica', 0), (@g9, 'Italia', 0), (@g9, 'España', 0),
                                                                    (@g10, 'El Sahara', 1), (@g10, 'El Ártico', 0), (@g10, 'El Gobi', 0), (@g10, 'El Kalahari', 0);

SET FOREIGN_KEY_CHECKS=1;