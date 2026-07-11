-- ============================================================
--  Refresca las fechas de registro de los usuarios a fechas
--  recientes, para que los gráficos de barra del admin
--  (usuarios por país / sexo / edad) muestren datos con
--  cualquier filtro de período (Día / Semana / Mes / Año).
--
--  Pensado para la base de DEMO / local. En una base con
--  usuarios reales NO hace falta (ellos ya tienen su fecha real).
--
--  Ejecutar en phpMyAdmin sobre la base 'preguntados'.
-- ============================================================

-- Reparte los registros en los últimos ~10 días (según el id de cada usuario).
UPDATE usuario
SET fecha_creacion = DATE_SUB(NOW(), INTERVAL (id % 10) DAY);

-- Asegura que al menos un usuario (el admin) figure como de HOY,
-- para que el filtro "Día" también muestre datos.
UPDATE usuario
SET fecha_creacion = NOW()
WHERE rol = 'administrador';
