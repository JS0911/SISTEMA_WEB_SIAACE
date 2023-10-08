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
require_once("../modelos/objetos.php"); 

$com = new Objetos(); 

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetObjetos":
        $datos = $com->get_objetos();
        echo json_encode($datos);
        break;

    case "InsertObjeto":
        $datos = $com->insert_objeto(
            $body["ID_OBJETO"],
            $body["OBJETO"],
            $body["DESCRIPCION"],
            $body["TIPO_OBJETO"]
        );
        echo json_encode("Objeto Insertado");
        break;

    case "GetObjeto":
        $datos = $com->get_objeto($body["ID_OBJETO"]);
        echo json_encode($datos);
        break;

    case "UpdateObjeto":
        $ID_OBJETO = $body["ID_OBJETO"];
        $OBJETO = $body["OBJETO"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $TIPO_OBJETO = $body["TIPO_OBJETO"];

        $datos = $com->update_objeto(
            $ID_OBJETO,
            $OBJETO,
            $DESCRIPCION,
            $TIPO_OBJETO
        );
        echo json_encode($datos);
        break;

    case "EliminarObjeto":
        $ID_OBJETO = $body["ID_OBJETO"];
        $datos = $com->eliminar_objeto($ID_OBJETO);
        echo json_encode("Objeto eliminado");
        break;
}
?>
