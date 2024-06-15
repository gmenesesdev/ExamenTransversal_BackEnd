<?php
/*
-- nuestros-jugadores !Revisar datos de RRSS
SELECT
	j.id,
	CONCAT( j.nombre, ' ', j.apellido ) AS Nombre,
	j.profesion,
	jp.abreviado,
	jp.nombre AS 'NombrePosicion',
	rs.nombre AS 'NombreRS',
	rs.icono,
	jrs.valor,
	j.activo 
FROM
	jugador j
	LEFT JOIN jugador_posicion jp ON j.posicion_id = jp.id
	LEFT JOIN jugador_rrss jrs ON j.id = jrs.jugador_id
	LEFT JOIN red_social rs ON jrs.red_social_id = rs.id;
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
					j.id,
					CONCAT( j.nombre, ' ', j.apellido ) AS nombre_jugador,
					j.profesion,
					jp.abreviado,
					jp.nombre AS 'nombre_posicion',
					rs.nombre AS 'nombre_red_social',
					rs.icono,
					jrs.valor,
					j.activo 
				FROM
					jugador j
					LEFT JOIN jugador_posicion jp ON j.posicion_id = jp.id
					LEFT JOIN jugador_rrss jrs ON j.id = jrs.jugador_id
					LEFT JOIN red_social rs ON jrs.red_social_id = rs.id;";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			$jugadores = [];
			while ($row = mysqli_fetch_assoc($result)) {
				$id_jugador = $row['id'];
				if (!isset($jugadores[$id_jugador])) {
					$jugadores[$id_jugador] = [
						"id" => $row["id"],
						"nombre" => $row["nombre_jugador"],
						"profesion" => $row["profesion"],
						"posicion" => [
							"abreviatura" => $row["abreviado"],
							"nombre" => $row["nombre_posicion"]
						],
						"redes_sociales" => [
							"nombre" => $row["nombre_red_social"],
							"icono" => $row["icono"],
							"valor" => $row["valor"]
						],
						"activo" => $row["activo"] == 1 ? true : false
					];
				}
			}
			$this->lista = array_values($jugadores);
			mysqli_free_result($result);
		}
		$con->closeConnection();
		return $this->lista;
	}

	public function postNewPlayer($_objeto)
	{
		$con = new Conexion();
		$ids = array_column($this->getAll(), 'id');
		$id = $ids ? max($ids) + 1 : 1;
		$sql = "INSERT INTO jugador (id, nombre, apellido, profesion, posicion_id, activo) VALUES ($id,'$_objeto->nombre','$_objeto->apellido','$_objeto->profesion',$_objeto->posicion_id,'$_objeto->activo ? 1 : 0');";
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
		$sql = "UPDATE jugador SET activo = '$accion' WHERE id = $id;";
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

	public function putNombreByID($id, $nombre)
	{
		$con = new Conexion();
		$sql = "UPDATE jugador SET nombre = '$nombre' WHERE id = $id;";
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

	public function putApellidoByID($id, $apellido)
	{
		$con = new Conexion();
		$sql = "UPDATE jugador SET apellido = '$apellido' WHERE id = $id;";
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

	public function putProfesionByID($id, $profesion)
	{
		$con = new Conexion();
		$sql = "UPDATE jugador SET profesion = '$profesion' WHERE id = $id;";
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

	public function putPosicionByID($id, $posicion)
	{
		$con = new Conexion();
		$sql = "UPDATE jugador SET posicion_id = '$posicion' WHERE id = $id;";
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

	public function putAll($id, $nombre, $apellido, $profesion, $posicion)
	{
		$con = new Conexion();
		$sql = "UPDATE jugador SET nombre = '$nombre', apellido = '$apellido', profesion = '$profesion', posicion_id = '$posicion' WHERE id = $id;";
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
		$sql = "DELETE FROM jugador WHERE id = $id;";
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
