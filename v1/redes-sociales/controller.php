<?php

/*
-- redes-sociales
SELECT id, nombre, icono, valor, activo FROM redes_sociales;
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
        $sql = 'SELECT id, nombre, icono, valor, activo FROM redes_sociales;';
        $result = mysqli_query($conn, $sql);
        if($result){
            $redes = [];
            while($row = mysqli_fetch_assoc($result)){
                $redes_id = $row['id'];
                if(!isset($redes[$redes_id])){
                    $redes[$redes_id] = [
                        "id" => $row["id"],
                        "nombre" => $row["nombre"],
                        "icono" => $row["icono"],
                        "valor" => $row["valor"],
                        "activo" => $row["activo"] == 1 ? true : false
                    ];
                }
            }
            $this->lista = array_values($redes);
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
        $nombre = $_objeto->nombre;
        $icono = $_objeto->icono;
        $valor = $_objeto->valor;
        $activo = $_objeto->activo ? 1 : 0;
        $sql = "INSERT INTO redes_sociales (id, nombre, icono, valor, activo) VALUES ($id, '$nombre', '$icono', $valor, $activo);";
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
        $sql = "UPDATE redes_sociales SET activo = $_accion WHERE id = $_id;";
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

    public function putNombreByID($nombre, $id)
    {
        $con = new Conexion();
        $sql = "UPDATE redes_sociales SET nombre = '$nombre' WHERE id = $id;";
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

    public function putIconoByID($icono, $id)
    {
        $con = new Conexion();
        $sql = "UPDATE redes_sociales SET icono = '$icono' WHERE id = $id;";
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

    public function putValorByID($valor, $id)
    {
        $con = new Conexion();
        $sql = "UPDATE redes_sociales SET valor = $valor WHERE id = $id;";
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

    public function putAll($id, $nombre, $icono, $valor)
    {
        $con = new Conexion();
        $sql = "UPDATE redes_sociales SET nombre = '$nombre', icono = '$icono', valor = $valor WHERE id = $id;";
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
        $sql = "DELETE FROM redes_sociales WHERE id = $id;";
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