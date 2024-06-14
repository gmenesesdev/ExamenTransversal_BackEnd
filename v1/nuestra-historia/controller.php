<?php
/*-- nuestra-historia 
SELECT id, texto, activo FROM nuestra_historia;
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
        $sql = 'SELECT id, texto, activo FROM nuestra_historia;';
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $historia = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $historia_id = $row['id'];
                if (!isset($historia[$historia_id])) {
                    $historia[$historia_id] = [
                        "id" => $row["id"],
                        "texto" => $row["texto"],
                        "activo" => $row["activo"] == 1 ? true : false
                    ];
                }
            }
            $this->lista = array_values($historia);
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
        $sql = "INSERT INTO nuestra_historia (id, texto, activo) VALUES ($id, '$_objeto->texto', $_objeto->activo ? 1 : 0);";
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

    public function patchOnOff($id, $accion)
    {
        $con = new Conexion();
        $sql = "UPDATE nuestra_historia SET activo = $accion WHERE id = $id;";
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

    public function putTextoByID($texto, $id)
    {
        $con = new Conexion();
        $sql = "UPDATE nuestra_historia SET texto = '$texto' WHERE id = $id;";
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

    public function putAll($texto, $id)
    {
        $con = new Conexion();
        $sql = "UPDATE nuestra_historia SET texto = '$texto' WHERE id = $id;";
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
        $sql = "DELETE FROM nuestra_historia WHERE id = $id;";
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
