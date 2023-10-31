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
        $datos = $com->insert_prestamo($body["ID_EMPLEADO"], $body["ID_TIPO_PRESTAMO"], $body["ID_FPAGO"], $body["FECHA_SOLICITUD"], $body["FECHA_APROBACION"], $body["FECHA_DE_CANCELACION"]
        , $body["FECHA_DE_DESEMBOLSO"], $body["ESTADO_PRESTAMO"], $body["MONTO_SOLICITADO"], $body["MONTO_DESEMBOLSO"], $body["MONTO_ADEUDADO"]);
        echo json_encode("Prestamo Insertado");
        break;

    case "GetPrestamo":
        $datos = $com->get_Prestamo($body["ID_PRESTAMO"]);
        echo json_encode($datos);
        break;

    case "updatePrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $ID_FPAGO = $body["ID_FPAGO"];
        $FECHA_DE_CANCELACION = $body["FECHA_DE_CANCELACION"];
        $FECHA_DE_DESEMBOLSO = $body["FECHA_DE_DESEMBOLSO"];
        $ESTADO_PRESTAMO = $body["ESTADO_PRESTAMO"];
        $MONTO_SOLICITADO = $body["MONTO_SOLICITADO"];
        $MONTO_DESEMBOLSO = $body["MONTO_DESEMBOLSO"];
        $MONTO_ADEUDADO = $body["MONTO_ADEUDADO"];

        $datos = $com->update_prestamo($ID_PRESTAMO, $ID_FPAGO, $FECHA_DE_CANCELACION, $FECHA_DE_DESEMBOLSO, $ESTADO_PRESTAMO, $MONTO_SOLICITADO, $MONTO_DESEMBOLSO, $MONTO_ADEUDADO);
        echo json_encode($datos);
        break;
    case "anularPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $datos = $com->anular_prestamo($ID_PRESTAMO);
        echo json_encode($datos);
        break;
}
