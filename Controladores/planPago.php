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
require_once("../Modelos/planPago.php");


$com = new planPago();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetPlanPago":
        $datos = $com->get_planPago($body["ID_PRESTAMO"]);
        echo json_encode($datos);
    break;
    case "calcularCuota":
        $datos = $com->calcularCuota($body["TASA"], $body["PLAZO"], $body["MONTO_SOLICITADO"], $body["PLAZOQUINCENAS"]);
        echo json_encode($datos);
    break;
    case "InsertarAmortizacion":
        $datos = $com->InsertarAmortizacion($body["ID_PRESTAMO"], $body["TASA"], $body["PLAZO"], $body["MONTO_SOLICITADO"], $body["PLAZOQUINCENAS"]);
        echo json_encode($datos);
    break;
    case "calcularInteresCapital":
        $datos = $com->calcularInteresCapital($body["TASA"], $body["SALDO"], $body["VALOR_CUOTA"]);
        echo json_encode($datos);
    break;
    case "PagoTotalCuota":
        $datos = $com->PagoTCuota($body["ID_PPAGO"]);
        echo json_encode($datos);
    break;
    case "PagoCapital":
        $datos = $com->PagoCapital($body["ID_PPAGO"]);
        echo json_encode($datos);
    break;
    case "PagoInteres":
        $datos = $com->PagoInteres($body["ID_PPAGO"]);
        echo json_encode($datos);
    break;
    case "PagoTEstado":
        $datos = $com->PAGOT_ESTADO($body["ID_PPAGO"]);
        echo json_encode($datos);
    break;
    case "PagoPEstado":
        $datos = $com->PAGOP_ESTADO($body["ID_PPAGO"]);
        echo json_encode($datos);
    break;
    case "obtenerEstadoPago":
        $ID_PPAGO = $body["ID_PPAGO"];
        $datos = $com->obtenerEstadoPago($ID_PPAGO);
        echo json_encode($datos);
    break;
    case "cuotaActual":
        $ID_PPAGO = $body["ID_PPAGO"];
        $datos = $com->get_cuotaActual($ID_PPAGO);
        echo json_encode($datos);
    break;
    case "estadoFinalizado":
        $ID_PPAGO = $body["ID_PPAGO"];
        $datos = $com->EstadoFinalizado($ID_PPAGO);
        echo json_encode($datos);
    break;
}
