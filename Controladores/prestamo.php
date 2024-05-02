<?php

session_start();

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
require_once("../Modelos/bitacora.php");

$com = new Prestamo();
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetPrestamos":
        $datos = $com->get_prestamos();
        echo json_encode($datos);
    break;

    case "InsertPrestamo":
        $ID_EMPLEADO = $body["ID_EMPLEADO"]; 
        $ID_TIPO_PRESTAMO = $body["ID_TIPO_PRESTAMO"]; 
        $ID_FPAGO = $body["ID_FPAGO"];
        $PLAZO = $body["PLAZO"];
        $TASA = $body["TASA"];
        $MONTO_SOLICITADO = $body["MONTO_SOLICITADO"]; 
        $ESTADO_PRESTAMO = $body["ESTADO_PRESTAMO"];

        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");
        $datos = $com->insert_prestamo($ID_EMPLEADO, $ID_TIPO_PRESTAMO, $ID_FPAGO, $TASA, $PLAZO, $MONTO_SOLICITADO, $ESTADO_PRESTAMO);
        echo json_encode(["message" => "Prestamo insertado Exitosamente."]);
        $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO EL PRESTAMO: $ID_TIPO_PRESTAMO PARA EL EMPLEADO: $ID_EMPLEADO", $_SESSION['id_usuario'], 30, $_SESSION['usuario'], $dateNew);
    break;

    case "GetPrestamo":
        $datos = $com->get_Prestamo($body["ID_EMPLEADO"]);
        echo json_encode($datos);
    break;
    case "get_PrestamoRecibo":
        $datos = $com->get_PrestamoRecibo($body["ID_PRESTAMO"]);
        echo json_encode($datos);
    break;

    case "anularPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");
        $datos = $com->anular_prestamo($ID_PRESTAMO);
        echo json_encode(["message" => "Prestamo anulado Exitosamente."]);
        $bit->insert_bitacora($dateNew, "ANULAR", "SE ANULO EL PRESTAMO: $ID_PRESTAMO", $_SESSION['id_usuario'], 30, $_SESSION['usuario'], $dateNew);
    break;

    case "aprobarPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");
        $datos = $com->aprobar_prestamo($ID_PRESTAMO);
        echo json_encode(["message" => "Prestamo aprobado Exitosamente."]);
        $bit->insert_bitacora($dateNew, "APROBAR", "SE APROBO EL PRESTAMO: $ID_PRESTAMO", $_SESSION['id_usuario'], 30, $_SESSION['usuario'], $dateNew);
    break;

    case "desembolsoPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");
        $datos = $com->desembolso_prestamo($ID_PRESTAMO , $_SESSION['usuario']);
       // echo json_encode(["message" => "Desembolso realizado Exitosamente."]);
        $bit->insert_bitacora($dateNew, "DESEMBOLSO", "SE DESEMBOLSO CHEQUE DEL PRESTAMO: $ID_PRESTAMO", $_SESSION['id_usuario'], 30, $_SESSION['usuario'], $dateNew);
    break;

    case "obtenerEstadoPrestamo":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $datos = $com->obtenerEstadoPrestamo($ID_PRESTAMO);
        echo json_encode($datos);
    break;
    case "SaldoTotal":
        $ID_PRESTAMO = $body["ID_PRESTAMO"];
        $datos = $com->SaldoTotal($ID_PRESTAMO);
        echo json_encode($datos);
    break;
    case "ValidarMonto":
        $ID_EMPLEADO = $body["ID_EMPLEADO"];
        $MONTO_SOLICITADO = $body["MONTO_SOLICITADO"];
        $datos = $com->validarMonto($ID_EMPLEADO,$MONTO_SOLICITADO);
        echo json_encode($datos);
    break;
}
