<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../Modelos/estadousuario.php"); 

$com = new Estados(); 

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetEstados":
        $datos = $com->get_estados();
        echo json_encode($datos);
        break;

    case "InsertEstado":
        $datos = $com->insert_estado(
            $body["NOMBRE"],
            $body["DESCRIPCION"],
        );
        echo json_encode("Estado Insertado");
        break;

    case "GetEstado":
        $datos = $com->get_estado($body["ID_ESTADO_USUARIO"]);
        echo json_encode($datos);
        break;

    case "UpdateEstado":
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $NOMBRE = $body["NOMBRE"];
        $DESCRIPCION = $body["DESCRIPCION"];

        $datos = $com->update_estado(
            $ID_ESTADO_USUARIO,
            $NOMBRE,
            $DESCRIPCION,
        );
        echo json_encode($datos);
        break;

    case "EliminarEstado":
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $datos = $com->eliminar_estado($ID_ESTADO_USUARIO);
        echo json_encode("Estado eliminado");
        break;
}
?>