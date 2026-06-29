<?php
class CategoriaModel
{
private $database;

public function __construct($database)
{
$this->database = $database;
}

public function obtenerTodas()
{
    $sql = "SELECT * FROM categoria ORDER BY nombre";
    return $this->database->query($sql);
}

public function obtenerCategoriaRandom()
{
$sql = "SELECT * FROM categoria ORDER BY RAND() LIMIT 1";
$result = $this->database->query($sql);

return $result[0] ?? null;
}

public function obtenerPorId($id)
{
$sql = "SELECT * FROM categoria WHERE id = ?";
$result = $this->database->query($sql, [$id]);

return $result[0] ?? null;
}
}