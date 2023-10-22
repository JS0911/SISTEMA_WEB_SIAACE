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
require_once("../Modelos/sucursal.php");


$com = new Sucursal();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetSucursales":
        $datos = $com->get_sucursales();
        echo json_encode($datos);
        break;

    case "InsertSucursal":
        $datos = $com->insert_sucursal($body["SUCURSAL"], $body["DESCRIPCION"], $body["DIRECCION"], $body["ESTADO"], $body["TELEFONO"]);
        echo json_encode("Sucursal Insertada");
        break;

    case "GetSucursal":
        $datos = $com->get_sucursal($body["ID_SUCURSAL"]);
        echo json_encode($datos);
        break;

    case "updateSucursal":
        $ID_SUCURSAL = $body["ID_SUCURSAL"];
        $SUCURSAL = $body["SUCURSAL"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $DIRECCION = $body["DIRECCION"];
        $ESTADO = $body["ESTADO"];
        $TELEFONO = $body["TELEFONO"];

        $datos = $com->update_sucursal($ID_SUCURSAL, $SUCURSAL, $DESCRIPCION , $DIRECCION,$ESTADO,$TELEFONO);
        echo json_encode($datos);
        break;
    case "eliminarSucursal":
        $ID_SUCURSAL = $body["ID_SUCURSAL"];
        $datos = $com->eliminar_sucursal($ID_SUCURSAL);
        echo json_encode("Sucursal eliminada");
        break;
}
?>
