create schema aldea_vikinga;
use aldea_vikinga;
create table aldea_vikinga.guerreros
(
    id        int auto_increment
        primary key,
    nombre    varchar(50)                           not null,
    apodo     varchar(50)                           null,
    clan      varchar(50)                           null,
    fuerza    int       default 0                   null,
    creado_en timestamp default current_timestamp() not null
);

INSERT INTO aldea_vikinga.guerreros (id, nombre, apodo, clan, fuerza, creado_en) VALUES (23, 'Aslaug', 'La Reina', 'Volsung', 82, '2026-04-28 21:52:34');
INSERT INTO aldea_vikinga.guerreros (id, nombre, apodo, clan, fuerza, creado_en) VALUES (24, 'Harald', 'Cabellera Hermosa', 'Noruega', 94, '2026-04-28 21:52:34');
INSERT INTO aldea_vikinga.guerreros (id, nombre, apodo, clan, fuerza, creado_en) VALUES (26, 'Astrid', 'La Valiente (casi)', 'Hedeby', 87, '2026-04-28 21:52:34');

CREATE TABLE aldea_vikinga.usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    anio_nacimiento INT NOT NULL,
    sexo ENUM('Masculino', 'Femenino', 'Prefiero no cargarlo') NOT NULL,
    pais VARCHAR(100) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    foto_perfil VARCHAR(255) NULL,
    rol ENUM('jugador', 'editor', 'administrador') DEFAULT 'jugador',
    puntaje_total INT DEFAULT 0,
    activo TINYINT(1) DEFAULT 0,
    token_validacion VARCHAR(255) NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);