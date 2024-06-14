<?php

/*-- sobre-nosotros
SELECT id, logo_color, descripcion, activo FROM sobre_nosotros;
*/
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
        $sql = 'SELECT id, logo_color, descripcion, activo FROM sobre_nosotros;';
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $nosotros = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $nosotros_id = $row['id'];
                if (!isset($nosotros[$nosotros_id])) {
                    $nosotros[$nosotros_id] = [
                        "id" => $row["id"],
                        "logo_color" => $row["logo_color"],
                        "descripcion" => $row["descripcion"],
                        "activo" => $row["activo"] == 1 ? true : false
                    ];
                }
            }
            $this->lista = array_values($nosotros);
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
        $logo_color = $_objeto->logo_color;
        $descripcion = $_objeto->descripcion;
        $activo = $_objeto->activo ? 1 : 0;
        $sql = "INSERT INTO sobre_nosotros (id, logo_color, descripcion, activo) VALUES ($id, '$logo_color', $descripcion, $activo);";
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
        $sql = "UPDATE sobre_nosotros SET activo = $_accion WHERE id = $_id;";
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
    public function putLogoColorByID($_logo_color, $_id)
    {
        $con = new Conexion();
        $sql = "UPDATE sobre_nosotros SET logo_color = '$_logo_color' WHERE id = $_id;";
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

    public function putDescripcionByID($_descripcion, $_id)
    {
        $con = new Conexion();
        $sql = "UPDATE sobre_nosotros SET descripcion = '$_descripcion' WHERE id = $_id;";
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

    public function putAll($id, $logo_color, $descripcion)
    {
        $con = new Conexion();
        $sql = "UPDATE sobre_nosotros SET logo_color = '$logo_color', descripcion = '$descripcion' WHERE id = $id;";
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

    public function deleteByID($_id)
    {
        $con = new Conexion();
        $sql = "DELETE FROM sobre_nosotros WHERE id = $_id;";
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
