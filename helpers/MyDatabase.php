<?php

class MyDatabase
{
    private $conexion;

    public function __construct($hostname, $username, $password, $database)
    {
        $this->conexion = new mysqli($hostname, $username, $password, $database);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($params);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($params);
        return $this->conexion->affected_rows;
    }
    public function lastInsertId() //guardar el partida_id en la sesion despues de crear la partida, metodo usado en partidaModel.
    {
        return $this->conexion->insert_id;
    }
    public function __destruct()
    {
        $this->conexion->close();
    }
}
