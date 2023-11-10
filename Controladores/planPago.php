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
    case "InsertPlanPago":
        $ID_PRESTAMO = 8;
        $datos = $com->insert_amortizacion(
            $ID_PRESTAMO,$body["FECHA_VENC_C"], $body["NUMERO_CUOTA"], $body["FECHA_R_PAGO"], $body["VALOR_CUOTA"], $body["MONTO_ADEUDADO"], 
            $body["MONTO_PAGADO"], $body["MONTO_ADEUDADO_CAP"], $body["MONTO_PAGADO_CAP"], 
            $body["MONTO_ADEUDADO_ITS"], $body["MONTO_PAGADO_ITS"], $body["MONTO_ADEUDADO_MORA"],
            $body["MONTO_PAGADO_MORA"], $body["ESTADO"]
        );
        echo json_encode($datos);
        break;

        case "calcularCuota":
            $datos = $com->calcularCuota($body["TASA"],$body["PLAZO"],$body["MONTO_SOLICITADO"],$body["PLAZOQUINCENAS"]);
            echo json_encode($datos);
        break;
        case "repetirIdPrestamo":
            $datos = $com->repetirIDPrestamo($body["ID_PRESTAMO"],$body["TASA"],$body["PLAZO"],$body["MONTO_SOLICITADO"],$body["PLAZOQUINCENAS"]);
            echo json_encode($datos);
        break;
}
