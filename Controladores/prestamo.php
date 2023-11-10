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
require_once("../Modelos/prestamo.php");


$com = new Prestamo();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetPrestamos":
        $datos = $com->get_prestamos();
        echo json_encode($datos);
    break;

    case "InsertPrestamo":
        $datos = $com->insert_prestamo( $body["ID_EMPLEADO"], $body["ID_TIPO_PRESTAMO"], $body["ID_FPAGO"], $body["PLAZO"], $body["TASA"], $body["MONTO_SOLICITADO"], $body["ESTADO_PRESTAMO"]);
        echo json_encode($datos);
    break;

    case "GetPrestamo":
        $datos = $com->get_Prestamo($body["ID_EMPLEADO"]);
        echo json_encode($datos);
    break;

    case "anularPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $datos = $com->anular_prestamo($ID_PRESTAMO);
        echo json_encode($datos);
    break;

    case "aprobarPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $datos = $com->aprobar_prestamo($ID_PRESTAMO);
        echo json_encode($datos);
    break;

    case "desembolsoPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $datos = $com->desembolso_prestamo($ID_PRESTAMO);
        echo json_encode($datos);
    break;

    case "obtenerEstadoPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $datos = $com->obtenerEstadoPrestamo($ID_PRESTAMO);
        echo json_encode($datos);
    break;

}
