<?php
include_once '../version1.php';

$existeId = false;
$valorId = 0;
$existeAccion = false;
$valorAccion = 0;

if (count($_parametros) > 0) {
    foreach ($_parametros as $p) {
        if (strpos($p, 'id') !== false) {
            $existeId = true;
            $valorId = explode('=', $p)[1];
        }
        if (strpos($p, 'accion') !== false) {
            $existeAccion = true;
            $valorAccion = explode('=', $p)[1];
        }
    }
}

if ($_version == 'v1') {
    if ($_mantenedor == 'nuestra-historia') {
        switch ($_metodo) {
            case 'GET':
                if ($_header == $_token_get) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $lista = $control->getAll();
                    http_response_code(200);
                    echo json_encode(["data" => $lista]);
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion GET"]);
                }
                break;
            case 'POST':
                if ($_header == $_token_post) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $objeto = json_decode(file_get_contents("php://input", true));
                    $rs = $control->postNew($objeto);
                    if ($rs) {
                        http_response_code(201);
                        echo json_encode(["data" => $rs]);
                    } else if ($rs === false) {
                        echo "ID repetido";
                    } else {
                        echo json_encode(["Error" => "Error al crear historia"]);
                        http_response_code(409);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion POST"]);
                }
                break;
            case 'PATCH':
                if ($_header == $_token_patch) {
                    if ($existeId && $existeAccion) {
                        include_once 'controller.php';
                        include_once '../conexion.php';
                        $control = new Controlador();
                        if ($valorAccion == 'on') {
                            $rs = $control->patchOnOff($valorId, 'true');
                            http_response_code(200);
                            echo json_encode(["data" => $rs]);
                        } else if ($valorAccion == 'off') {
                            $rs = $control->patchOnOff($valorId, 'false');
                            http_response_code(200);
                            echo json_encode(["data" => $rs]);
                        } else {
                            http_response_code(400);
                            echo json_encode(["Error" => "Error con acciones"]);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(["Error" => "Error con parametros"]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion PATCH"]);
                }
                break;
            case 'PUT':
                if ($_header == $_token_put) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $objeto = json_decode(file_get_contents("php://input", true));
                    switch (true) {
                        case property_exists($objeto, 'texto') && $objeto->texto:
                            $rs = $control->putTextoByID($objeto->texto, $objeto->id);
                            http_response_code(200);
                            echo json_encode(["data" => $rs]);
                            break;
                        default:
                            http_response_code(400);
                            echo json_encode(["Error" => "Error con parametros"]);
                            break;
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion PUT"]);
                }
                break;

            case 'DELETE':
                if ($_header == $_token_delete) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    if ($existeId) {
                        $rs = $control->getAll();
                        $existeRegistro = false;
                        foreach ($rs as $r) {
                            if ($r['id'] == $valorId) {
                                $existeRegistro = true;
                            }
                        }
                        if ($existeRegistro) {
                            $rs = $control->deleteByID($valorId);
                            http_response_code(200);
                            echo json_encode(["data" => $rs]);
                        } else {
                            http_response_code(404);
                            echo json_encode(["data" => "no existe el registro"]);
                        }
                    } else {
                        http_response_code(406);
                        echo json_encode(["Error" => false]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion DELETE"]);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(["Error" => "No implementado"]);
                break;
        }
    }
}
