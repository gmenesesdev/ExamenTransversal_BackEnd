<?php

/*-- proximos-entrenamientos
SELECT
	ep.id AS 'id_entrenamiento',
	ep.fecha,
	ep.hora,
	el.id AS 'id_lugar',
	el.nombre,
	el.direccion,
	el.comuna,
	ep.activo 
FROM
	entrenamientos_proximos ep
	LEFT JOIN entrenamiento_lugar el ON ep.entrenamiento_lugar_id = el.id;
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
        $sql = "SELECT 
                    ep.id AS id_entrenamiento, 
                    ep.fecha, 
                    ep.hora, 
                    el.id AS id_lugar, 
                    el.nombre,
                    el.direccion,
                    el.comuna,
                    ep.activo 
                FROM entrenamientos_proximos ep 
                LEFT JOIN entrenamiento_lugar el ON ep.entrenamiento_lugar_id = el.id;";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $entrenamientos = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $id_entrenamiento = $row['id_entrenamiento'];
                if (!isset($entrenamientos[$id_entrenamiento])) {
                    $entrenamientos[$id_entrenamiento] = [
                        "id" => $row["id_entrenamiento"],
                        "momento" => [
                            "fecha" => $row["fecha"],
                            "horario" => $row["hora"]
                        ],
                        "lugar" => [
                            "id" => $row["id_lugar"],
                            "nombre" => $row["nombre"],
                            "direccion" => [
                                "calle" => $row["direccion"],
                                "comuna" => $row["comuna"]
                            ]
                        ],
                        "activo" => $row["activo"] == 1 ? true : false
                    ];
                }
            }
            $this->lista = array_values($entrenamientos);
            mysqli_free_result($result);
        }
        $con->closeConnection();
        return $this->lista;
    }

    public function postNewEntrenamiento($_objeto)
    {
        $con = new Conexion();
        $ids = array_column($this->getAll(), 'id');
        $id = $ids ? max($ids) + 1 : 1;
        $sql = "INSERT INTO entrenamientos_proximos (id, fecha, hora, entrenamiento_lugar_id, activo) VALUES ($id, '$_objeto->fecha', '$_objeto->hora', '$_objeto->entrenamiento_lugar_id', '$_objeto->activo ? 1 : 0');";
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
        $sql = "UPDATE entrenamientos_proximos SET activo = $_accion WHERE id = $_id;";
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

    public function putFechaByID($id, $fecha)
    {
        $con = new Conexion();
        $sql = "UPDATE entrenamientos_proximos SET fecha = '$fecha' WHERE id = $id;";
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

    public function putHoraByID($id, $hora)
    {
        $con = new Conexion();
        $sql = "UPDATE entrenamientos_proximos SET hora = '$hora' WHERE id = $id;";
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

    public function putLugarByID($id, $lugar)
    {
        $con = new Conexion();
        $sql = "UPDATE entrenamientos_proximos SET entrenamiento_lugar_id = $lugar WHERE id = $id;";
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

    public function putAll($id, $fecha, $hora, $lugar)
    {
        $con = new Conexion();
        $sql = "UPDATE entrenamientos_proximos SET fecha = '$fecha', hora = '$hora', entrenamiento_lugar_id = $lugar WHERE id = $id;";
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
        $sql = "DELETE FROM entrenamientos_proximos WHERE id = $_id;";
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
