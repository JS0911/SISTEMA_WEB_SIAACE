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
require_once("../Modelos/parametros.php");


$com = new Parametro();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetParametros":
        $datos = $com->get_parametros();
        echo json_encode($datos);
        break;

    case "InsertParametros":
        $datos = $com->insert_parametros($body["PARAMETRO"], $body["VALOR"]/* , $body["ID_USUARIO"], $body["CREADO_POR"], $body["MODIFICADO_POR"] *//* , $body["FECHA_CREACION"], $body["FECHA_MODIFICACION "]*/);
        echo json_encode("Parametro Insertado");
        break;

    case "GetParametro":
        $datos = $com->get_parametro($body["ID_PARAMETRO"]);
        echo json_encode($datos);
        break;

    case "updateParametro":
        $ID_PARAMETRO = $body["ID_PARAMETRO"];
        $PARAMETRO = $body["PARAMETRO"];
        $VALOR = $body["VALOR"];
/*         $ID_USUARIO = $body["ID_USUARIO"];
        $CREADO_POR = $body["CREADO_POR"];
        $MODIFICADO_POR = $body["MODIFICADO_POR"]; */
/*         $FECHA_CREACION = $body["FECHA_CREACION"];
        $FECHA_MODIFICACION = $body["FECHA_MODIFICACION"]; */


        $datos = $com->update_parametro($ID_PARAMETRO, $PARAMETRO, $VALOR/* , $ID_USUARIO, $CREADO_POR, $MODIFICADO_POR *//* , $FECHA_CREACION, $FECHA_MODIFICACION */);
        echo json_encode($datos);
        break;
    case "eliminarParametro":
        $ID_PARAMETRO = $body["ID_PARAMETRO"];
        $datos = $com->eliminar_parametro($ID_PARAMETRO);
        echo json_encode("Parametro eliminado");
        break;
}
?>
