<?php

class Controlador
{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll()
    {
        $con = new Conexion();
        $conn = $con->getConnection();
        $sql = 'SELECT id, imagen, titulo, descripcion, activo FROM	carrusel;';
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $carrusel = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $carrusel_id = $row['id'];
                if (!isset($carrusel[$carrusel_id])) {
                    $carrusel[$carrusel_id] = [
                        "id" => $row["id"],
                        "imagen" => $row["imagen"],
                        "titulo" => $row["titulo"],
                        "descripcion" => $row["descripcion"],
                        "activo" => $row["activo"] == 1 ? true : false
                    ];
                }
            }
            $this->lista = array_values($carrusel);
            mysqli_free_result($result);
        }
        $con->closeConnection();
        return $this->lista;
    }
}
