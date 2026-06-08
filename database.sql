CREATE DATABASE IF NOT EXISTS preguntados;
USE preguntados;

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(120) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    anio_nacimiento INT NOT NULL,
    sexo ENUM('Masculino', 'Femenino', 'Prefiero no cargarlo') NOT NULL,
    pais VARCHAR(100) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    foto_perfil VARCHAR(255),
    rol ENUM('jugador', 'editor', 'administrador') DEFAULT 'jugador',
    activo TINYINT(1) DEFAULT 0,
    token_validacion VARCHAR(255),
    puntaje_total INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contraseña: "1234" hasheada con PASSWORD_BCRYPT
INSERT INTO usuario (
    nombre_completo,
    username,
    email,
    password,
    anio_nacimiento,
    sexo,
    pais,
    ciudad,
    foto_perfil,
    rol,
    activo,
    token_validacion,
    puntaje_total
) VALUES (
    'Administrador Sistema',
    'admin',
    'admin@quizmaster.com',
    '$2y$10$bEnbfmueUi8C4LSJIPti0eRx52/5fUl1Vh4O5Tey7m1pAI3DEcDLO',
    1990,
    'Masculino',
    'Argentina',
    'Buenos Aires',
    NULL,
    'administrador',
    1,
    NULL,
    0
);