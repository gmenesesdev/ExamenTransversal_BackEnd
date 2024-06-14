<?php
/*-- Carrusel 
SELECT id, imagen, titulo, descripcion, activo FROM carrusel;
*/
class Controlador
{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    // Obtener todos los datos de carusel
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

    public function postNew($_objeto)
    {
        $con = new Conexion();
        $ids = array_column($this->getAll(), 'id');
        $id = $ids ? max($ids) + 1 : 1;
        $sql = "INSERT INTO carrusel (id, imagen, titulo, descripcion, activo) VALUES ($id, '$_objeto->imagen', '$_objeto->titulo', '$_objeto->descripcion', '$_objeto->activo ? 1 : 0');";
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }
    
    public function patchOnOff($_id, $_accion)
    {
        $con = new Conexion();
        $sql = "UPDATE carrusel SET activo = $_accion WHERE id = $_id;";
        var_dump($sql);
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putImagenByID($imagen, $id)
    {
        $con = new Conexion();
        $sql = "UPDATE carrusel SET imagen = '$imagen' WHERE id = $id;";
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putTituloByID($titulo, $id)
    {
        $con = new Conexion();
        $sql = "UPDATE carrusel SET titulo = '$titulo' WHERE id = $id;";
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putDescripcionByID($descripcion, $id)
    {
        $con = new Conexion();
        $sql = "UPDATE carrusel SET descripcion = '$descripcion' WHERE id = $id;";
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putAll($id, $imagen, $titulo, $descripcion)
    {
        $con = new Conexion();
        $sql = "UPDATE carrusel SET imagen = '$imagen', titulo = '$titulo', descripcion = '$descripcion', activo WHERE id = $id;";
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function deleteByID($id)
    {
        $con = new Conexion();
        $sql = "DELETE FROM carrusel WHERE id = $id;";
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }
}
