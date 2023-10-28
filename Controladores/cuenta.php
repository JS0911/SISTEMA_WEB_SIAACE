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
require_once("../Modelos/cuenta.php");


$com = new cuenta();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetCuentas":
        $datos = $com->get_cuentas();
        echo json_encode($datos);
        break;

    case "GetCuenta":
        $datos = $com->get_cuenta($body["ID_CUENTA"]);
        echo json_encode($datos);
        break;

}
?>