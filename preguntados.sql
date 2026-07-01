-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 11:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `preguntados`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
                             `id` int(11) NOT NULL,
                             `nombre` varchar(50) NOT NULL,
                             `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `color`) VALUES
                                                      (1, 'Historia', '#fdd835'),
                                                      (2, 'Deportes', '#fb8c00'),
                                                      (3, 'Ciencia', '#43a047'),
                                                      (4, 'Arte', '#e53935'),
                                                      (5, 'Entretenimiento', '#8e24aa'),
                                                      (6, 'Geografía', '#1e88e5');

-- --------------------------------------------------------

--
-- Table structure for table `partida`
--

CREATE TABLE `partida` (
                           `id` int(11) NOT NULL,
                           `usuario_id` int(11) NOT NULL,
                           `fecha_inicio` datetime DEFAULT current_timestamp(),
                           `fecha_fin` datetime DEFAULT NULL,
                           `puntaje` int(11) DEFAULT 0,
                           `estado` enum('EN_CURSO','FINALIZADA') DEFAULT 'EN_CURSO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partida`
--

INSERT INTO `partida` (`id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `puntaje`, `estado`) VALUES
                                                                                                 (1, 6, '2026-06-17 16:36:12', '2026-06-17 16:39:21', 0, 'FINALIZADA'),
                                                                                                 (2, 6, '2026-06-17 16:39:31', '2026-06-17 16:39:31', 0, 'FINALIZADA'),
                                                                                                 (3, 6, '2026-06-17 16:48:24', '2026-06-17 16:48:36', 1, 'FINALIZADA'),
                                                                                                 (4, 6, '2026-06-17 16:53:48', '2026-06-17 16:54:50', 5, 'FINALIZADA'),
                                                                                                 (5, 6, '2026-06-17 17:04:15', '2026-06-17 17:04:26', 0, 'FINALIZADA'),
                                                                                                 (6, 6, '2026-06-17 17:17:17', '2026-06-17 17:17:37', 2, 'FINALIZADA'),
                                                                                                 (7, 6, '2026-06-17 17:17:39', '2026-06-17 17:17:53', 2, 'FINALIZADA'),
                                                                                                 (8, 6, '2026-06-17 17:20:27', '2026-06-17 17:21:01', 3, 'FINALIZADA'),
                                                                                                 (9, 6, '2026-06-17 17:39:03', '2026-06-17 17:39:19', 1, 'FINALIZADA'),
                                                                                                 (10, 6, '2026-06-17 17:41:54', '2026-06-17 17:42:07', 0, 'FINALIZADA'),
                                                                                                 (11, 6, '2026-06-17 17:42:49', '2026-06-17 17:44:06', 2, 'FINALIZADA'),
                                                                                                 (12, 6, '2026-06-17 17:44:38', '2026-06-17 17:44:55', 2, 'FINALIZADA'),
                                                                                                 (13, 6, '2026-06-17 17:44:57', '2026-06-17 17:45:26', 5, 'FINALIZADA'),
                                                                                                 (14, 6, '2026-06-17 17:58:54', '2026-06-17 17:59:34', 6, 'FINALIZADA');

-- --------------------------------------------------------

--
-- Table structure for table `pregunta`
--

CREATE TABLE `pregunta` (
                            `id` int(11) NOT NULL,
                            `enunciado` text NOT NULL,
                            `categoria_id` int(11) NOT NULL,
                            `creador_id` int(11) DEFAULT NULL,
                            `fecha_creacion` datetime DEFAULT current_timestamp(),
                            `estado` enum('PENDIENTE','APROBADA','RECHAZADA') DEFAULT 'PENDIENTE',
                            `veces_mostrada` int(11) DEFAULT 0,
                            `veces_correcta` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pregunta`
--

INSERT INTO `pregunta` (`id`, `enunciado`, `categoria_id`, `creador_id`, `fecha_creacion`, `estado`, `veces_mostrada`, `veces_correcta`) VALUES
                                                                                                                                             (1, '¿Cuál es la capital de Argentina?', 6, 6, '2026-06-17 16:44:45', 'APROBADA', 2, 2),
                                                                                                                                             (2, '¿En qué año comenzó la Primera Guerra Mundial?', 1, 6, '2026-06-17 16:52:44', 'APROBADA', 3, 1),
                                                                                                                                             (3, '¿Quién fue el primer presidente de Argentina?', 1, 6, '2026-06-17 16:52:44', 'APROBADA', 0, 0),
                                                                                                                                             (4, '¿Cuántos jugadores tiene un equipo de fútbol en cancha?', 2, 6, '2026-06-17 16:52:44', 'APROBADA', 4, 4),
                                                                                                                                             (5, '¿Qué país ganó el Mundial de Fútbol 2022?', 2, 6, '2026-06-17 16:52:44', 'APROBADA', 2, 2),
                                                                                                                                             (6, '¿Cuál es el planeta más cercano al Sol?', 3, 6, '2026-06-17 16:52:44', 'APROBADA', 4, 2),
                                                                                                                                             (7, '¿Qué gas necesitan las plantas para realizar la fotosíntesis?', 3, 6, '2026-06-17 16:52:44', 'APROBADA', 2, 1),
                                                                                                                                             (8, '¿Quién pintó la Mona Lisa?', 4, 6, '2026-06-17 16:52:44', 'APROBADA', 2, 2),
                                                                                                                                             (9, '¿En qué país se encuentra el Museo del Louvre?', 4, 6, '2026-06-17 16:52:44', 'APROBADA', 2, 2),
                                                                                                                                             (10, '¿Cuál es el nombre del mago protagonista de Harry Potter?', 5, 6, '2026-06-17 16:52:44', 'APROBADA', 6, 6),
                                                                                                                                             (11, '¿Qué compañía creó la consola PlayStation?', 5, 6, '2026-06-17 16:52:44', 'APROBADA', 5, 5),
                                                                                                                                             (12, '¿Cuál es el río más largo del mundo según la mayoría de las mediciones?', 6, 6, '2026-06-17 16:52:44', 'APROBADA', 3, 1),
                                                                                                                                             (13, '¿Cuál es el país más grande del mundo?', 6, 6, '2026-06-17 16:52:44', 'APROBADA', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `respuesta`
--

CREATE TABLE `respuesta` (
                             `id` int(11) NOT NULL,
                             `pregunta_id` int(11) NOT NULL,
                             `texto` varchar(255) NOT NULL,
                             `es_correcta` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `respuesta`
--

INSERT INTO `respuesta` (`id`, `pregunta_id`, `texto`, `es_correcta`) VALUES
                                                                          (1, 1, 'Buenos Aires', 1),
                                                                          (2, 1, 'Córdoba', 0),
                                                                          (3, 1, 'Rosario', 0),
                                                                          (4, 1, 'Mendoza', 0),
                                                                          (5, 2, '1914', 1),
                                                                          (6, 2, '1939', 0),
                                                                          (7, 2, '1810', 0),
                                                                          (8, 3, 'Bernardino Rivadavia', 1),
                                                                          (9, 3, 'Julio A. Roca', 0),
                                                                          (10, 3, 'Domingo F. Sarmiento', 0),
                                                                          (11, 4, '11', 1),
                                                                          (12, 4, '9', 0),
                                                                          (13, 4, '13', 0),
                                                                          (14, 5, 'Argentina', 1),
                                                                          (15, 5, 'Francia', 0),
                                                                          (16, 5, 'Brasil', 0),
                                                                          (17, 6, 'Mercurio', 1),
                                                                          (18, 6, 'Venus', 0),
                                                                          (19, 6, 'Marte', 0),
                                                                          (20, 7, 'Dióxido de carbono', 1),
                                                                          (21, 7, 'Oxígeno', 0),
                                                                          (22, 7, 'Hidrógeno', 0),
                                                                          (23, 8, 'Leonardo da Vinci', 1),
                                                                          (24, 8, 'Pablo Picasso', 0),
                                                                          (25, 8, 'Vincent van Gogh', 0),
                                                                          (26, 9, 'Francia', 1),
                                                                          (27, 9, 'Italia', 0),
                                                                          (28, 9, 'España', 0),
                                                                          (29, 10, 'Harry Potter', 1),
                                                                          (30, 10, 'Ron Weasley', 0),
                                                                          (31, 10, 'Hermione Granger', 0),
                                                                          (32, 11, 'Sony', 1),
                                                                          (33, 11, 'Nintendo', 0),
                                                                          (34, 11, 'Microsoft', 0),
                                                                          (35, 12, 'Amazonas', 1),
                                                                          (36, 12, 'Nilo', 0),
                                                                          (37, 12, 'Paraná', 0),
                                                                          (38, 13, 'Rusia', 1),
                                                                          (39, 13, 'Canadá', 0),
                                                                          (40, 13, 'China', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
                           `id` int(11) NOT NULL,
                           `nombre_completo` varchar(120) NOT NULL,
                           `username` varchar(50) NOT NULL,
                           `email` varchar(120) NOT NULL,
                           `password` varchar(255) NOT NULL,
                           `anio_nacimiento` int(11) NOT NULL,
                           `sexo` enum('Masculino','Femenino','Prefiero no cargarlo') NOT NULL,
                           `pais` varchar(100) NOT NULL,
                           `ciudad` varchar(100) NOT NULL,
                           `foto_perfil` varchar(255) DEFAULT NULL,
                           `rol` enum('jugador','editor','administrador') DEFAULT 'jugador',
                           `activo` tinyint(1) DEFAULT 0,
                           `token_validacion` varchar(255) DEFAULT NULL,
                           `puntaje_total` int(11) DEFAULT 0,
                           `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
                           `total_preguntas_respondidas` int(11) DEFAULT 0,
                           `total_respuestas_correctas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nombre_completo`, `username`, `email`, `password`, `anio_nacimiento`, `sexo`, `pais`, `ciudad`, `foto_perfil`, `rol`, `activo`, `token_validacion`, `puntaje_total`, `fecha_creacion`, `total_preguntas_respondidas`, `total_respuestas_correctas`) VALUES
                                                                                                                                                                                                                                                                                      (2, 'juan', 'juan', 'vghj@gmail.com', '$2y$10$JeC/1/30Q10buBBhreXDa.0T6mJd8JUR4B3GlalHbMXWIHkF3biHW', 1911, 'Prefiero no cargarlo', 'Argentina', 'Ciudad Evita', NULL, 'jugador', 0, 'cf6d0a7b7bfebd34f170f8ead268efbb0cc39b9dc392691b7d06e521b6ce214b', 0, '2026-06-07 20:31:39', 0, 0),
                                                                                                                                                                                                                                                                                      (3, 'valen', 'valen', 'valen@gmail.com', '$2y$10$LJzfDG.pQHuCtnXtaRpJP.G6vg44JtvIw3jNxwUhXKQyD8iSdtsUO', 1900, 'Masculino', 'Argentina', 'San Justo', NULL, 'jugador', 0, '67ac3ffdc25223df768ff5d1ed9868877b65123f4427105c0f983f2be1d20fd4', 0, '2026-06-07 20:33:28', 0, 0),
                                                                                                                                                                                                                                                                                      (6, 'Administrador', 'admin', 'admin@quizmaster.com', '$2y$10$5vABRu65CkIqnhP5IxDRReXNns.Pfmw7wslth4o58mfktT8m0zaC2', 2000, 'Prefiero no cargarlo', 'Argentina', 'San Justo', NULL, 'administrador', 1, '10c2feda33379142b4c62fa5be55d4f8e092a14ac72728d344ded04a2a1fc5a9', 29, '2026-06-10 13:55:45', 35, 29);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partida`
--
ALTER TABLE `partida`
    ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `pregunta`
--
ALTER TABLE `pregunta`
    ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `creador_id` (`creador_id`);

--
-- Indexes for table `respuesta`
--
ALTER TABLE `respuesta`
    ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partida`
--
ALTER TABLE `partida`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pregunta`
--
ALTER TABLE `pregunta`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `respuesta`
--
ALTER TABLE `respuesta`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `partida`
--
ALTER TABLE `partida`
    ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `pregunta`
--
ALTER TABLE `pregunta`
    ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `pregunta_ibfk_2` FOREIGN KEY (`creador_id`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `respuesta`
--
ALTER TABLE `respuesta`
    ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`id`);

-- --------------------------------------------------------

--
-- Table structure for table `reporte`
--

CREATE TABLE `reporte` (
    `id`            int(11)      NOT NULL AUTO_INCREMENT,
    `pregunta_id`   int(11)      NOT NULL,
    `usuario_id`    int(11)      NOT NULL,
    `motivo`        varchar(255) DEFAULT NULL,
    `fecha_reporte` datetime     DEFAULT current_timestamp(),
    `estado`        enum('PENDIENTE','RESUELTO') DEFAULT 'PENDIENTE',
    PRIMARY KEY (`id`),
    KEY `pregunta_id` (`pregunta_id`),
    KEY `usuario_id` (`usuario_id`),
    CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`id`),
    CONSTRAINT `reporte_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuario_pregunta`
-- (registra que preguntas ya vio cada usuario)
--

CREATE TABLE `usuario_pregunta` (
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `usuario_id`  int(11) NOT NULL,
    `pregunta_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_usuario_pregunta` (`usuario_id`, `pregunta_id`),
    KEY `usuario_id` (`usuario_id`),
    KEY `pregunta_id` (`pregunta_id`),
    CONSTRAINT `up_fk_usuario`  FOREIGN KEY (`usuario_id`)  REFERENCES `usuario` (`id`),
    CONSTRAINT `up_fk_pregunta` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
